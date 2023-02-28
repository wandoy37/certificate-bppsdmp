<?php

namespace Database\Factories;

use App\Models\Certificate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certificate>
 */
class CertificateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Last data
        $lastCertificate = Certificate::all()->count();
        $lastCertificate++;
        return [
            'code' => str_pad($lastCertificate, 4, '0', STR_PAD_LEFT),
            'training_id' => 1,
            'participant_id' => 1,
            'penandatangan_id' => 1,
            'tanggal_terbit' => 'unknowed'
        ];
    }
}
