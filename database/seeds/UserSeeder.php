<?php

use Illuminate\Database\Seeder;
use App\User;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'firstname' => 'Adedayo',
            'lastname' => 'Matthew',
            'email' => 'adedayomatt@gmail.com',
            'password' => bcrypt('pass'),
            'position' => 1,
            'remember_token' => str_random(10)
        ]);
    }
}
