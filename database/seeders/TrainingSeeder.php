<?php

namespace Database\Seeders;

use App\Models\Training;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Training::create([
            'code' => '000.01',
            'title' => 'Pelatihan Agribisnis Tanaman Pangan dan Hortikultura',
            'slug' => 'pelatihan-agribisnis-tanaman-pangan-dan-Hortikultura',
            // 'batch' => '1',
            'year' => '2023',
            'hour' => '72',
            'tanggal_pelaksanaan' => '15 Februari sampai dengan 19 Februari 2023',
            // 'start_date' => '2023-01-10 00:00:00',
            // 'end_date' => '2023-02-10 00:00:00',
            'tempat' => 'Unit Kantor Satu',
            'category_id' => '2',
        ]);

        Training::create([
            'code' => '000.02',
            'title' => 'Pelatihan Teknologi Pengolahan Hasil Pertanian Tingkat Lanjutan Bagi Aparatur',
            'slug' => 'pelatihan-teknologi-pengolahan-hasil-pertanian-tingkat-lanjutan-bagi-aparatur',
            // 'batch' => '1',
            'year' => '2023',
            'hour' => '72',
            'tanggal_pelaksanaan' => '20 Februari sampai dengan 24 Februari 2023',
            // 'start_date' => '2023-01-10 00:00:00',
            // 'end_date' => '2023-02-10 00:00:00',
            'tempat' => 'Unit Kantor Dua',
            'category_id' => '1',
        ]);
    }
}
