<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'kharismatics@gmail.com',
            'password' => bcrypt('admin'),
            'api_token' => base64_encode(Str::random(40)),
            'created_at' => DB::raw('now()'),  
        ]);
    }
}