<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummySeederUsers extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $userData = [
            // Peneliti
            [
                'name' => $faker->name,
                'email' => 'peneliti@gmail.com',
                'role' => 'Peneliti',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'nomor_hp' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'institusi' => $faker->company,
                'status_peneliti' => 'Mahasiswa (S1)',
                'asal_peneliti' => 'Eksternal',
            ],
            // Administrator
            [
                'name' => $faker->name,
                'email' => 'administrator@gmail.com',
                'role' => 'Administrator',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'nomor_hp' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'institusi' => $faker->company,
                'status_peneliti' => 'Dosen',
                'asal_peneliti' => 'UNUJA',
            ],
            // Penguji 1
            [
                'name' => $faker->name,
                'email' => 'penguji@gmail.com',
                'role' => 'Penguji',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'nomor_hp' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'institusi' => $faker->company,
                'status_peneliti' => 'Dosen',
                'asal_peneliti' => 'UNUJA',
            ],
            // Penguji 2
            [
                'name' => $faker->name,
                'email' => 'penguji2@gmail.com',
                'role' => 'Penguji',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'nomor_hp' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'institusi' => $faker->company,
                'status_peneliti' => 'Dosen',
                'asal_peneliti' => 'UNUJA',
            ],
            // Penguji 3
            [
                'name' => $faker->name,
                'email' => 'penguji3@gmail.com',
                'role' => 'Penguji',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'nomor_hp' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'institusi' => $faker->company,
                'status_peneliti' => 'Dosen',
                'asal_peneliti' => 'UNUJA',
            ],
            // Kepk
            [
                'name' => $faker->name,
                'email' => 'kepk@gmail.com',
                'role' => 'Kepk',
                'password' => bcrypt('password'),
                'email_verified_at' => now(),
                'nomor_hp' => $faker->phoneNumber,
                'alamat' => $faker->address,
                'institusi' => $faker->company,
                'status_peneliti' => 'Dosen',
                'asal_peneliti' => 'UNUJA',
            ],
        ];

        foreach ($userData as $key => $val) {
            User::create($val) ;
        }
    }
}
