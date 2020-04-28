<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            array(
                array(
                    'name' => 'Administrator',
                    'email' => 'admin@gmail.com',
                    'role' => 1,
                    'email_verified_at' => now(),
                    'password' => '$2y$10$pzY2x8VTLIVO/Hbex.XC2uz5W6XYQ7LkfM6/Cq/Fq0olWHtqYkG4e', // mightyegg
                    'remember_token' => Str::random(10),
                ),
                array(
                    'name' => 'Staff',
                    'email' => 'staff@gmail.com',
                    'role' => 2,
                    'email_verified_at' => now(),
                    'password' => '$2y$10$pzY2x8VTLIVO/Hbex.XC2uz5W6XYQ7LkfM6/Cq/Fq0olWHtqYkG4e', // mightyegg
                    'remember_token' => Str::random(10),
                ),
            )
        );
    }
}
