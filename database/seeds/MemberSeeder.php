<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('members')->insert(
            array(
                array(
                    'first_name' => 'BurlSprings',
                    'last_name' => 'Freq Flyer-reserved',
                    // 'email' => 'flyer.reserved@gmail.com',
                    'membership_type' => 'flyer',
                    'discount_id' => '0999',
                    // 'device' => 'paper',
                    'print_count' => 0,
                    'is_admin' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ),
                array(
                    'first_name' => 'BurlSprings',
                    'last_name' => 'Regular-reserved',
                    // 'email' => 'regular.reserved@gmail.com',
                    'membership_type' => 'regular',
                    'discount_id' => '6999',
                    // 'device' => 'paper',
                    'print_count' => 0,
                    'is_admin' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ),
                array(
                    'first_name' => 'BurlSprings',
                    'last_name' => 'Senior-reserved',
                    // 'email' => 'senior.reserved@gmail.com',
                    'membership_type' => 'senior',
                    'discount_id' => '9999',
                    // 'device' => 'paper',
                    'print_count' => 0,
                    'is_admin' => 1,
                    'created_at' => now(),
                    'updated_at' => now()
                ),
            )
        );
    }
}
