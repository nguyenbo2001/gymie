<?php

use Illuminate\Database\Seeder;

use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'gymie',
            'email' => 'nguyenbo2001@gmail.com',
            'password' => bcrypt('abc123456'),
            'status' => '1'
        ]);
    }
}
