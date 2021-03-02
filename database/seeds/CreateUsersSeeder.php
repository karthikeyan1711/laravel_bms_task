<?php

use Illuminate\Database\Seeder;
use App\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
        		   'name'=>'Admin',
	               'email'=>'admin@gmail.com',
	               'user_type'=>'1',
	               'phone_number'=>'1234567',
	               'state_id'=>'1',
	               'city_id'=>'1',
	               'address'=>'CBE',
	               'password'=> bcrypt('admin@123'),
        		];

        User::create($user);
    }
}
