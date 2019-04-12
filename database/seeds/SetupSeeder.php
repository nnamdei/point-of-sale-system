<?php

use Illuminate\Database\Seeder;
use App\Admin;
use App\User;
use App\Shop;
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
         $admins = array(
                [
                    'firstname' => 'System',
                    'lastname' => 'Default',
                    'email' => 'adedayomatt@gmail.com',
                    'level' => 'superadmin',
                    'remember_token' => str_random(10),
                    'password' => bcrypt('pass'),
                ]
            );

                    // default shop
        $shop = Shop::create([
            'name' => config('app.name')
        ]);

        foreach($admins as $admin){
            $user = User::create([
                'email' => $admin['email'],
                'shop_id' => $shop->id,
                'role' => 'admin',
                'password' => $admin['password'],
            ]);

            $admin = Admin::create([
                'user_id' => $user->id,
                'firstname' => $admin['firstname'],
                'lastname' => $admin['lastname'],
                'email' => $admin['email'],
                'level' => $admin['level'],
            ]);
        }



        // default category
        $category = Category::create([
            'user_id' => $user->id,
            'shop_id' => 1,
            'name' => 'uncategorized'
        ]);

    }
}
