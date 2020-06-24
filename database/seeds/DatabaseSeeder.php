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
        // $this->call(UserSeeder::class);
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => DB::raw('md5("12345678")'),
            'api_token' => base64_encode(Str::random(40)),
            'created_at' => DB::raw('now()'),  
        ]);
    }
}
