<?php

namespace Database\Seeders;

use App\Models\Kasbon;
use App\Models\Pegawai;
use Illuminate\Database\Seeder;

class KasbonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Kasbon::create();
        $pegawai = Pegawai::get();
        // pengajuan 2 bulan
        for($i=1;$i<=2;$i++)
        {
            // pengajuan 3 kasbon
            for($j=1;$j<=3;$j++)
            {
                foreach($pegawai as $peg)
                {
                    if($peg->id <= 5 && $j == 3) continue;
                    if($i == 1)
                    Kasbon::create([
                        'tanggal_diajukan' => '2021-12-'.rand(15,31),
                        'pegawai_id'   => $peg->id,
                        'total_kasbon' => rand(300000,600000)
                    ]);

                    if($i == 2)
                    Kasbon::create([
                        'tanggal_diajukan' => '2022-01-'.rand(1,15),
                        'pegawai_id'   => $peg->id,
                        'total_kasbon' => rand(300000,600000)
                    ]);
                }
            }
        }
    }
}
