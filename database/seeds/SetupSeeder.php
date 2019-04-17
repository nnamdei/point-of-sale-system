<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Admin;
use App\User;
use App\Shop;
use App\Setting;
use App\Software;
use App\Category;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //default superadmin
         $admin = array(
                    'firstname' => 'System',
                    'lastname' => 'Default',
                    'email' => 'adedayomatt@gmail.com',
                    'level' => 'superadmin',
                    'remember_token' => str_random(10),
                    'password' => 'pass'
            );

       Software::create([
            'name' => config('app.name'),
            'version' => 'v2.0'
        ]);

        $superadmin = Admin::create([
            'firstname' => $admin['firstname'],
            'lastname' => $admin['lastname'],
            'email' => $admin['email'],
            'level' => $admin['level']
        ]);

        $user = User::create([
            'email' => $admin['email'],
            'admin_id' => $superadmin->id,
            'password' => Hash::make($admin['password'])
        ]);
    
    }
}
