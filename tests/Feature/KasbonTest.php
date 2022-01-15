<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Pegawai;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class KasbonTest extends TestCase
{
    use WithFaker;

    public function test_get_kasbon()
    {
        $response = $this->get('/api/kasbon',['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_get_kasbon_with_bulan_success()
    {
        $response = $this->get('/api/kasbon?bulan=2021-11',['Accept'=>'application/json']);

        $response->assertStatus(200);
    }

    public function test_get_kasbon_with_bulan_fail()
    {
        $response = $this->get('/api/kasbon?bulan=helloworld',['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_get_kasbon_success_with_belum_disetujui()
    {
        $response = $this->get('/api/kasbon?bulan=2021-11&belum_disetujui=1',['Accept'=>'application/json']);

        $response->assertStatus(200);
    }

    public function test_get_kasbon_with_page_success()
    {
        $response = $this->get('/api/kasbon?bulan=2021-11&page=1',['Accept'=>'application/json']);

        $response->assertStatus(200);
    }

    public function test_get_kasbon_with_page_fail()
    {
        $response = $this->get('/api/kasbon?bulan=2021-11&page=helloworld',['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_kasbon_without_send_formdata()
    {
        $response = $this->post('/api/kasbon',[],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_kasbon_success()
    {
        $pegawai = Pegawai::create([
            'nama' => $this->faker->text(10),
            'tanggal_masuk' => date('Y-m-d',strtotime('-1 years')),
            'total_gaji'    => rand(4000000,10000000)
        ]);
        $response = $this->post('/api/kasbon',[
            'pegawai_id' => $pegawai->id,
            'total_kasbon' => 100000,
        ],['Accept'=>'application/json']);

        $response->assertStatus(200);
    }

    public function test_create_kasbon_with_pegawai_id_string()
    {
        $response = $this->post('/api/kasbon',[
            'pegawai_id' => 'hello',
            'total_kasbon' => 100000,
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_kasbon_with_pegawai_id_not_required()
    {
        $response = $this->post('/api/kasbon',[
            'total_kasbon' => 100000,
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_kasbon_with_pegawai_id_not_exists()
    {
        $response = $this->post('/api/kasbon',[
            'pegawai_id' => -1,
            'total_kasbon' => 100000,
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_kasbon_with_pegawai_id_exists_not_a_year_work()
    {
        $response = $this->post('/api/kasbon',[
            'pegawai_id' => 11,
            'total_kasbon' => 100000,
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_kasbon_with_pegawai_id_max_pengajuan()
    {
        $response = $this->post('/api/kasbon',[
            'pegawai_id' => 8,
            'total_kasbon' => 100000,
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_kasbon_with_total_kasbon_string()
    {
        $response = $this->post('/api/kasbon',[
            'pegawai_id' => 2,
            'total_kasbon' => 'helloworld',
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_kasbon_with_total_kasbon_max_limit()
    {
        $pegawai_id = 6;
        $pegawai = Pegawai::find($pegawai_id);
        $max = $pegawai->getRawOriginal('total_gaji') * 0.5;
        $response = $this->post('/api/kasbon',[
            'pegawai_id' => $pegawai_id,
            'total_kasbon' => $max,
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_kasbon_setujui_success()
    {
        $response = $this->patch('/api/kasbon/setujui/1',[],['Accept'=>'application/json']);
        $response->assertStatus(200);
    }

    public function test_kasbon_setujui_masal()
    {
        $response = $this->post('/api/kasbon/setujui-masal',[],['Accept'=>'application/json']);
        $response->assertStatus(200);
    }
}
