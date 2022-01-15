<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'tanggal_masuk'  => 'date:d/m/Y'
    ];

    function getNamaAttribute($value)
    {
        $nama = explode(' ',$value)[0];
        return strtoupper($nama);
    }

    function getTotalGajiAttribute($value)
    {
        return number_format($value,0,',','.');
    }

    function lastTotalKasbon()
    {
        $from = date('Y-m-d',strtotime('-1 month'));
        $to   = date('Y-m-d');
        return Kasbon::where('pegawai_id',$this->id)->whereBetween('tanggal_diajukan',[$from,$to])->sum('total_kasbon');
    }
}
