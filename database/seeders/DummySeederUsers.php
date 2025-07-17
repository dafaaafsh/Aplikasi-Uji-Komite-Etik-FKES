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
        $userData = [
            [
                'name' => 'Peneliti Pertama',
                'email' => 'peneliti1@gmail.com',
                'role' => 'Peneliti',
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
            ],[
                'name' => 'Peneliti Kedua',
                'email' => 'peneliti2@gmail.com',
                'role' => 'Peneliti',
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
            ],[
                'name' => 'Admin Pertama',
                'email' => 'admin1@gmail.com',
                'role' => 'Admin',
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
            ],[
                'name' => 'Penguji Pertama',
                'email' => 'penguji@gmail.com',
                'role' => 'Penguji',
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
            ],[
                'name' => 'Penguji Kedua',
                'email' => 'penguji2@gmail.com',
                'role' => 'Penguji',
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
            ],[
                'name' => 'Penguji Ketiga',
                'email' => 'penguji3@gmail.com',
                'role' => 'Penguji',
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
            ],[
                'name' => 'Kepk',
                'email' => 'kepk@gmail.com',
                'role' => 'Kepk',
                'password' => bcrypt('123456'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($userData as $key => $val) {
            User::create($val) ;
        }
    }
}
