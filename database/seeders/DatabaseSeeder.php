<?php

namespace Database\Seeders;

use App\Models\Kecamatan;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $kecamatan = [
            'Babat',
            'Bluluk',
            'Brondong',
            'Deket',
            'Glagah',
            'Kalitengah',
            'Karangbinangun',
            'Karanggeneng',
            'Kedungpring',
            'Kembangbahu',
            'Lamongan',
            'Laren',
            'Maduran',
            'Mantup',
            'Modo',
            'Ngimbang',
            'Paciran',
            'Pucuk',
            'Sambeng',
            'Sarirejo',
            'Sekaran',
            'Solokuro',
            'Sugio',
            'Sukodadi',
            'Sukorame',
            'Tikung',
            'Turi',
        ];

        foreach ($kecamatan as $value) {
            Kecamatan::create([
                'nama_kecamatan' => $value,
            ]);
        }

        // \App\Models\User::factory(10)->create();
    }
}
