<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Warga; // sesuaikan dengan nama model Anda
use Illuminate\Support\Str;

class WargaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_kk' => 'Imron Rosidi', 'no_telp' => '081328768206'],
            ['nama_kk' => 'Hardani', 'no_telp' => '087839898948'],
            ['nama_kk' => 'Ngatijan', 'no_telp' => '082327717403'],
            ['nama_kk' => 'Subarno', 'no_telp' => '082189265233'],
            ['nama_kk' => 'Sawon', 'no_telp' => '081338176254'],
            ['nama_kk' => 'Parijah', 'no_telp' => '081274522122'],
            ['nama_kk' => 'Sawal', 'no_telp' => '083104339563'],
            ['nama_kk' => 'Ngadi', 'no_telp' => '0895387766333'],
            ['nama_kk' => 'Mujilan', 'no_telp' => '082326256187'],
            ['nama_kk' => 'Wagi', 'no_telp' => '083151328581'],
            ['nama_kk' => 'Keman', 'no_telp' => '083831453817'],
            ['nama_kk' => 'Sarjoko', 'no_telp' => '081392199633'],
            ['nama_kk' => 'Suwiji', 'no_telp' => '081392202431'],
            ['nama_kk' => 'Tri Rohadi', 'no_telp' => '081774162326'],
            ['nama_kk' => 'Sarwadi', 'no_telp' => '081393718395'],
            ['nama_kk' => 'Surono', 'no_telp' => '085226748847'],
            ['nama_kk' => 'Ahmad', 'no_telp' => '088985150416'],
            ['nama_kk' => 'Agus Sumarsono', 'no_telp' => '085189005695'],
            ['nama_kk' => 'Sumardi', 'no_telp' => '083117796443'],
            ['nama_kk' => 'Fitri Marwanto', 'no_telp' => '085141654651'],
            ['nama_kk' => 'Miyati', 'no_telp' => '085184808200'],
            ['nama_kk' => 'Jemingan', 'no_telp' => '082148163057'],
            ['nama_kk' => 'Giwarno', 'no_telp' => '083836565328'],
            ['nama_kk' => 'Sujianto', 'no_telp' => '081339807194'],
            ['nama_kk' => 'Sukidal', 'no_telp' => '082135430783'],
            ['nama_kk' => 'Kaminm', 'no_telp' => '085721501771'],
            ['nama_kk' => 'Tuhardi', 'no_telp' => '08311845171'],
            ['nama_kk' => 'Suginem', 'no_telp' => '089652379567'],
            ['nama_kk' => 'Sugiyo', 'no_telp' => '088980875081'],
            ['nama_kk' => 'Tri Haryadi', 'no_telp' => '082324835269'],
            ['nama_kk' => 'Pardi', 'no_telp' => '083844138454'],
            ['nama_kk' => 'Rusmiyati', 'no_telp' => '085713565070'],
            ['nama_kk' => 'Suparjono', 'no_telp' => '0811256578'],
        ];

        foreach ($data as $index => $item) {
            // Generate kode unik: "KDT" + 3 karakter random (huruf/angka)
            $randomPart = strtoupper(Str::random(3));
            $kodeUnik = 'KDT' . $randomPart;

            Warga::create([
                'kode_unik' => $kodeUnik,
                'nama_kk'   => $item['nama_kk'],
                'alamat'    => 'Kedungtangkil',
                'rt'        => '63',
                'rw'        => '28',
                'no_rumah'  => $index + 1,
                'no_telp'   => $item['no_telp'],
                'status'    => 'aktif',
            ]);
        }
    }
}
