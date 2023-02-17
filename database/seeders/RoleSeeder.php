<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'title' => 'aparatur',
            'slug' => 'aparatur',
        ]);

        Role::create([
            'title' => 'non-aparatur',
            'slug' => 'non-aparatur',
        ]);

        Role::create([
            'title' => 'petani',
            'slug' => 'petani',
        ]);
    }
}
