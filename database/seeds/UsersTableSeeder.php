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
            'email' => 'gymie@gymie.io',
            'password' => bcrypt('abc123456'),
            'status' => '1'
        ]);
    }
}
