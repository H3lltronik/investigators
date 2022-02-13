<?php

namespace Database\Seeders;

use App\Models\Financial;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $admin = User::create([
            'name' => 'Super Admin',
            'email' => 'esau.egs1@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$UGUqS1adZtIN5SJbRvhKY.wo3tJwUBxdv9yIaW4EIuPqGmVepLA9m',
            'remember_token' => Str::random(10),
        ]);
        $admin->assignRole('SUPER ADMIN');

        $client = User::create([
            'name' => 'Client',
            'email' => 'client@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$UGUqS1adZtIN5SJbRvhKY.wo3tJwUBxdv9yIaW4EIuPqGmVepLA9m',
            'remember_token' => Str::random(10),
        ]);
        $client->assignRole('role.client');

        $financial = Financial::create([
            'name' => 'Financiera #1',
            'description' => 'Descripcion',
            'user_id' => $client->id,
        ]);

        $promoter = User::create([
            'name' => 'Promoter',
            'email' => 'promoter@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$UGUqS1adZtIN5SJbRvhKY.wo3tJwUBxdv9yIaW4EIuPqGmVepLA9m',
            'remember_token' => Str::random(10),
        ]);
        $promoter->assignRole('role.promoter');
    }
}
