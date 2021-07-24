<?php

use Illuminate\Database\Seeder;
namespace Database\Seeders;
use database\seeds\UsersTableSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
    }
}
