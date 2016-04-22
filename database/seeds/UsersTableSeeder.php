<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

/**
 * Class UsersTableSeeder
 */
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('referrals')->delete();
        DB::table('users')->delete();
        
        // factory(App\User::class, 5)->create();

        $faker = Faker::create();
        
        // 9 Users with random values
        foreach (range(1, 9) as $index) {
            // Hardcoded User
            if ($index === 2) {
                DB::table('users')->insert([
                    'name' => 'Jack Daniels',
                    'email' => 'jack@daniels.com',
                    'password' => bcrypt('secret'),
                    'created_at' => $faker->dateTimeThisMonth,
                    'updated_at' => $faker->dateTimeThisMonth,
                    //'amount' => 10.23
                ]);
            }
            
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->email,
                'password' => bcrypt('secret'),
                'created_at' => $faker->dateTimeThisMonth,
                'updated_at' => $faker->dateTimeThisMonth
            ]);
        }

        // 3 Referrals and 1 Referrer
        $lastUserId = DB::getPdo()->lastInsertId();
        DB::table('referrals')->insert([
            'referrer_id' => $lastUserId - 8,
            'referral_id' => $lastUserId - 7,
            'created_at' => $faker->dateTimeThisMonth,
            'updated_at' => $faker->dateTimeThisMonth
        ]);
        DB::table('referrals')->insert([
            'referrer_id' => $lastUserId - 8,
            'referral_id' => $lastUserId - 6,
            'created_at' => $faker->dateTimeThisMonth,
            'updated_at' => $faker->dateTimeThisMonth
        ]);
        DB::table('referrals')->insert([
            'referrer_id' => $lastUserId - 9,
            'referral_id' => $lastUserId - 8,
            'created_at' => $faker->dateTimeThisMonth,
            'updated_at' => $faker->dateTimeThisMonth
        ]);


    }

}
