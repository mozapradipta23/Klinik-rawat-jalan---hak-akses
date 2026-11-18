<?php

namespace Database\Seeders;

use App\Models\Dokter;
use Illuminate\Database\Seeder;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        // Data contoh dari klinik_rawat_jalan.sql. Nomor SIP dibuat unik
        // (di SQL lama ada 3 dokter dengan SIP yang sama).
        $data = [
            ['Dr. Rafli Kurniawan',     'Bekasi',  '2005-12-05', 'SIP-123458', 'Dokter Umum',              1, '0814-5678-9012', 'rafli@klinik.test'],
            ['Dr. Citra Wulandari',     'Bandung', '1960-01-30', 'SIP-223456', 'Spesialis Anak',           3, '0815-6789-0123', 'citra@klinik.test'],
            ['Dr. Muhammad Fachrezi',   'Padang',  '2000-01-01', 'SIP-223457', 'Spesialis Anak',           3, '0816-7890-1234', 'fachrezi@klinik.test'],
            ['Dr. Ayu Kartika',         'Bandung', '1960-01-20', 'SIP-323456', 'Spesialis Penyakit Dalam', 4, '0817-8901-2345', 'ayu@klinik.test'],
            ['Dr. Siti Zakiyah',        'Lampung', '2005-01-20', 'SIP-323457', 'Penyakit Dalam',           4, '0817-8901-2346', 'siti@klinik.test'],
            ['Dr. Andre Gibran',        'Bali',    '1960-01-20', 'SIP-323458', 'Spesialis Ortodonti',      2, '0817-8901-2347', 'andre@klinik.test'],
        ];

        foreach ($data as [$nama, $tempat, $tgl, $sip, $spes, $poli, $kontak, $email]) {
            Dokter::updateOrCreate(
                ['no_sip' => $sip],
                [
                    'nama_dokter'   => $nama,
                    'tempat_lahir'  => $tempat,
                    'tanggal_lahir' => $tgl,
                    'spesialisasi'  => $spes,
                    'id_poli'       => $poli,
                    'kontak'        => $kontak,
                    'email'         => $email,
                ]
            );
        }
    }
}
