<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class KasbonCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $pegawai_id = $this->pegawai_id;
        $rule = [
            'pegawai_id'   => [
                'bail',
                'required',
                'integer',
                Rule::exists('pegawais','id')->where('id',$pegawai_id)->where(function($q){
                    $date = date('Y-m-d',strtotime('-1 year'));
                    return $q->whereDate('pegawais.tanggal_masuk','<=',$date);
                }),
                'max_pengajuan',
            ],
            'total_kasbon' => 'required|integer'
        ];

        if(is_int($pegawai_id) && $pegawai_id > 0 && is_int($this->total_kasbon))
            $rule['total_kasbon'] .= '|total_kasbon';

        // if(is_string($pegawai_id) || !$pegawai_id)
        //     unset($rule['total_kasbon']);
        return $rule;
    }

    public function messages()
    {
        return [
            'pegawai_id.max_pengajuan' => 'The selected pegawai has max pengajuan.',
            'total_kasbon.total_kasbon' => 'Total Kasbon reach limit'
        ];
    }
}
