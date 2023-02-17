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
            'nip' => '-',
            'nik' => random_int(100000, 999999),
            'pangkat_golongan' => $this->faker->randomElement(['pangkat a', 'pangkat b', 'pangkat c', 'pangkat d']),
            'jabatan' => $this->faker->randomElement(['jabatan a', 'jabatan b', 'jabatan c', 'jabatan d']),
            'instansi' => $this->faker->randomElement(['instansi a', 'instansi b', 'instansi c', 'instansi d']),
            'email' => $this->faker->email(),
            'role_id' => $this->faker->numberBetween(1, 3),
            'training_id' => $this->faker->numberBetween(1, 2),
        ];
    }
}
