<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PegawaiCreateRequest extends FormRequest
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
        return [
            'nama'          => 'required|string|unique:pegawais|max:10',
            'tanggal_masuk' => 'required|date|after_or_equal:'.date('Y-m-d'),
            'total_gaji'    => 'required|integer|min:4000000|max:10000000'
        ];
    }
}
