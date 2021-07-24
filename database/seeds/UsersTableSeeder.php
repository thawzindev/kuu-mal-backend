<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
namespace Database\Seeders;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
    		[
    			'name' => 'SuperAdmin',
    			'email' => 'admin@gmail.com',
    			'phone' => '09799784957',
    			'role' => 1,
    			'password' => bcrypt('password'),
    			'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
    			'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
    		],
            [
                'name' => 'manager',
                'email' => 'manager@gmail.com',
                'phone' => '09799784957',
                'role' => 2,
                'password' => bcrypt('password'),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
                'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
    	]);
    }
}
