<?php

namespace App\Http\Controllers\Api;

use Validator;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\PegawaiGetRequest;
use App\Http\Requests\PegawaiCreateRequest;

class PegawaiController extends Controller
{
    //
    function get(PegawaiGetRequest $request)
    {
        $pegawai = new Pegawai;
        return $pegawai->paginate(10);
    }

    function create(PegawaiCreateRequest $request)
    {   
        $data    = $request->validated();
        $pegawai = Pegawai::create($data);
        return response()->json($pegawai,200);
    }
}
