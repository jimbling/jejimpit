<?php

namespace App\Http\Requests\Pengaturan\Sistem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSystemSettingRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ubah sesuai dengan kebutuhan otorisasi pengguna
    }

    public function rules()
    {
        return [
            'nama_dusun' => 'required|string|max:255',
            'nama_rt' => 'nullable|string|max:20',
            'nama_koordinator' => 'nullable|string',
            'desa_kelurahan' => 'nullable|string',
            'kecamatan' => 'nullable|string',
            'kabupaten_kota' => 'nullable|string',
            'provinsi' => 'nullable|string',
            'negara' => 'nullable|string',
            'kode_pos' => 'nullable|string|max:10',
            'website' => 'nullable|url',
            'email' => 'nullable|email',
            'no_telp' => 'nullable|string|max:20',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'favicon' => 'nullable|image|mimes:ico,png|max:1024',
            'kop_sekolah' => 'nullable|mimes:png,svg+xml|max:2048',
            'qrcode_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }
}
