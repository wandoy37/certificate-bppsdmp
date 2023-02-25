<?php

namespace Database\Seeders;

use App\Models\Certificate;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Certificate::factory()
        //     ->count(100)
        //     ->create();

        // Training id 1
        Certificate::create([
            'code' => '0001',
            'training_id' => '1',
            'participant_id' => '1'
        ]);

        Certificate::create([
            'code' => '0002',
            'training_id' => '1',
            'participant_id' => '2'
        ]);

        Certificate::create([
            'code' => '0003',
            'training_id' => '1',
            'participant_id' => '3'
        ]);

        Certificate::create([
            'code' => '0004',
            'training_id' => '1',
            'participant_id' => '4'
        ]);

        // Training id 2
        Certificate::create([
            'code' => '0005',
            'training_id' => '2',
            'participant_id' => '5'
        ]);

        Certificate::create([
            'code' => '0006',
            'training_id' => '2',
            'participant_id' => '6'
        ]);

        Certificate::create([
            'code' => '0007',
            'training_id' => '2',
            'participant_id' => '7'
        ]);

        Certificate::create([
            'code' => '0008',
            'training_id' => '2',
            'participant_id' => '8'
        ]);
    }
}
