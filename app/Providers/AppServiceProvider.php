<?php

namespace App\Providers;

use App\Models\Kasbon;
use App\Models\Pegawai;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Validator::extend('max_pengajuan', function($attribute, $value, $parameters) {
            $date = date('Y-m');
            return Kasbon::where($attribute,$value)->where('tanggal_diajukan','LIKE',$date.'%')->count() < 3;
        });

        Validator::extend('total_kasbon', function($attribute, $value, $parameters, $validator) {
            $pegawai = Pegawai::find($validator->getData()['pegawai_id']);
            $max = $pegawai->getRawOriginal('total_gaji') * 0.5;
            $total = $pegawai->lastTotalKasbon() + $value;
            return $total <= $max;
        });
    }
}
