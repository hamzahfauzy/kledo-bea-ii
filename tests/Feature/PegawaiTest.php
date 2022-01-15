<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PegawaiTest extends TestCase
{
    use WithFaker;

    public function test_get_pegawai()
    {
        $response = $this->get('/api/pegawai',['Accept'=>'application/json']);

        $response->assertStatus(200);
    }

    public function test_get_pegawai_with_param()
    {
        $response = $this->get('/api/pegawai?page=1',['Accept'=>'application/json']);

        $response->assertStatus(200);
    }

    public function test_get_pegawai_with_param_as_fail()
    {
        $response = $this->get('/api/pegawai?page=abc',['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_pegawai_success()
    {
        $response = $this->post('/api/pegawai',[
            'nama' => $this->faker->text(10),
            'tanggal_masuk' => date('Y-m-d'),
            'total_gaji'    => 4000000
        ],['Accept'=>'application/json']);

        $response->assertStatus(200);
    }

    public function test_create_pegawai_without_send_formdata()
    {
        $response = $this->post('/api/pegawai',[],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_pegawai_required_name()
    {
        $response = $this->post('/api/pegawai',[
            'tanggal_masuk' => '2022-01-15',
            'total_gaji' => 3000000
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_pegawai_unique_name()
    {
        $response = $this->post('/api/pegawai',[
            'nama' => 'Empl 1',
            'tanggal_masuk' => '2022-01-15',
            'total_gaji' => 3000000
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_pegawai_name_max_length()
    {
        $response = $this->post('/api/pegawai',[
            'nama' => $this->faker->text(11),
            'tanggal_masuk' => '2022-01-15',
            'total_gaji' => 3000000
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_pegawai_required_tanggal_masuk()
    {
        $response = $this->post('/api/pegawai',[
            'nama' => $this->faker->text(11),
            'total_gaji' => 3000000
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_pegawai_string_tanggal_masuk()
    {
        $response = $this->post('/api/pegawai',[
            'nama' => $this->faker->text(11),
            'tanggal_masuk' => $this->faker->text(11),
            'total_gaji' => 3000000
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_pegawai_less_tanggal_masuk()
    {
        $response = $this->post('/api/pegawai',[
            'nama' => $this->faker->text(11),
            'tanggal_masuk' => date('Y-m-d',strtotime('-1 days')),
            'total_gaji' => 3000000
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_pegawai_string_total_gaji()
    {
        $response = $this->post('/api/pegawai',[
            'nama' => $this->faker->text(10),
            'tanggal_masuk' => date('Y-m-d'),
            'total_gaji' => 'abcdefg'
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_pegawai_required_total_gaji()
    {
        $response = $this->post('/api/pegawai',[
            'nama' => $this->faker->text(10),
            'tanggal_masuk' => date('Y-m-d'),
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_pegawai_min_total_gaji()
    {
        $response = $this->post('/api/pegawai',[
            'nama' => $this->faker->text(10),
            'tanggal_masuk' => date('Y-m-d'),
            'total_gaji' => 3999999
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }

    public function test_create_pegawai_max_total_gaji()
    {
        $response = $this->post('/api/pegawai',[
            'nama' => $this->faker->text(10),
            'tanggal_masuk' => date('Y-m-d'),
            'total_gaji' => 10000001
        ],['Accept'=>'application/json']);

        $response->assertStatus(422);
    }
}
