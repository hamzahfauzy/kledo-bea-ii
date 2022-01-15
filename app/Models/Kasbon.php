<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasbon extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'tanggal_diajukan'  => 'date:d/m/Y',
        'tanggal_disetujui'  => 'date:d/m/Y'
    ];

    function getTotalKasbonAttribute($value)
    {
        return number_format($value,0,',','.');
    }

    public static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if(!$model->tanggal_diajukan)
                $model->tanggal_diajukan = date('Y-m-d');
        });
    }

}
