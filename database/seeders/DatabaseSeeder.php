<?php

namespace Database\Seeders;

<<<<<<< HEAD
use App\Models\User;

=======
>>>>>>> 1c0012bee38cf313557ad7a8a4ab4079b7510318
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
<<<<<<< HEAD
        // User::factory(10)->create();

        User::create([
            'name' => 'admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
=======
        $this->call([
            AdminSeeder::class,
>>>>>>> 1c0012bee38cf313557ad7a8a4ab4079b7510318
        ]);
    }
}
