<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Kasbon;
use Illuminate\Http\Request;
use App\Jobs\KasbonBulkApprove;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Requests\KasbonGetRequest;
use App\Http\Requests\KasbonCreateRequest;

class KasbonController extends Controller
{
    //
    function get(KasbonGetRequest $request)
    {
        $kasbon = Kasbon::join('pegawais','pegawais.id','=','kasbons.pegawai_id')
                    ->select('kasbons.*','pegawais.nama as nama_pegawai')
                    ->where('tanggal_diajukan','LIKE',$request->bulan.'%');

        if($request->belum_disetujui)
            $kasbon = $kasbon->whereNotNull('tanggal_disetujui');

        return $kasbon->paginate(10);
    }

    function create(KasbonCreateRequest $request)
    {
        $data    = $request->validated();
        $kasbon  = Kasbon::create($data);
        return response()->json($kasbon,200);
    }

    function approve($id)
    {
        $kasbon = Kasbon::join('pegawais','pegawais.id','=','kasbons.pegawai_id')
                    ->select('kasbons.*','pegawais.nama as nama_pegawai')
                    ->where('kasbons.id',$id)->firstOrFail();
        if($kasbon->tanggal_disetujui == NULL)
        $kasbon->update([
            'tanggal_disetujui' => date('Y-m-d')
        ]);

        return $kasbon;
    }

    function bulkApprove()
    {
        $date = date('Y-m');
        $kasbon = Kasbon::where('tanggal_diajukan','LIKE',$date.'%')->whereNull('tanggal_disetujui')->sum('total_kasbon');
        KasbonBulkApprove::dispatch();
        return $kasbon;
    }
}
