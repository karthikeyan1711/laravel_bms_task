<?php

use Illuminate\Database\Seeder;
use App\User;
use App\State;
use App\City;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $state_id = State::create(array('name'=>'Tamil nadu'))->id;
        $city_id = City::create(array('state_id'=>$state_id,'name'=>'Coimbatore'))->id;
        $cities = City::create(array('state_id'=>$state_id,'name'=>'Chennai',array('state_id'=>$state_id,'name'=>'Madurai'));

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
