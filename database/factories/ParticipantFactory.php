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
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug(),
            'nip' => rand(1000000000, 9999999999),
            'nik' => rand(1000000000, 9999999999),
            'birth' => $this->faker->dateTime(),
            'pangkat_golongan' => $this->faker->randomElement(['Golongan A', 'Golongan B', 'Golongan C', 'Golongan D']),
            'jabatan' => $this->faker->randomElement(['Pangkat A', 'Pangkat B', 'Pangkat C', 'Pangkat D']),
            'instansi' => $this->faker->randomElement(['Instansi A', 'Instansi B', 'Instansi C', 'Instansi D']),
            'email' => $this->faker->email(),
            'role_id' => $this->faker->randomElement([1, 2, 3]),
        ];
    }
}
