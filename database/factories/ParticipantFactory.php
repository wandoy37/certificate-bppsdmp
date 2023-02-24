<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Participant>
 */
class ParticipantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => '-',
            'slug' => '-',
            'nip' => '-',
            'nik' => '-',
            'birth' => '-',
            'pangkat_golongan' => '-',
            'jabatan' => '-',
            'instansi' => '-',
            'email' => '-',
            'role_id' => 1,
            'training_id' => 1,
        ];
    }
}
