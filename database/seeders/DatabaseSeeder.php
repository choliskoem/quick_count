<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        DB::table('t_pengguna')->insert([
            [
                'id_pengguna' => Str::uuid(),
                'nama' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('123456789'),
                'id_level' => '1'
            ],

        ]);


    }
}
