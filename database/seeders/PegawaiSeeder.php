<?php

namespace Database\Seeders;

use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class PegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=1;$i<=20;$i++)
        {
            Pegawai::create([
                'nama' => 'Empl '.$i,
                'tanggal_masuk' => $i<=10 ? date('Y-m-d',strtotime('-1 years')) :date('Y-m-d'),
                'total_gaji'    => rand(4000000,10000000)
            ]);
        }
    }
}
