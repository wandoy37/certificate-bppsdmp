<?php

namespace Database\Seeders;

use App\Models\Penandatangan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenandatanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Penandatangan::create([
            'name' => 'Ir. Siti Farisyah Yana, M.Si',
            'slug' => rand(10000, 99999),
            'nip' => '19690516 199301 2 001',
            'pangkat_golongan' => 'Pembina Utama Muda/IV. c',
            'jabatan' => 'Kepala Dinas',
        ]);

        Penandatangan::create([
            'name' => 'Tri Ida Kartini, SP., MP',
            'slug' => rand(10000, 99999),
            'nip' => '19740421 200112 2 005',
            'pangkat_golongan' => 'Pembina IV / a',
            'jabatan' => 'Kepala UPTD BPPSDMP',
        ]);
    }
}
