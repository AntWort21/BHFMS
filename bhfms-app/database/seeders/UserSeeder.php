<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

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
            "user_name" =>'Admin 1',
            "gender"=>'1',
            "email" =>'admin1@gmail.com',
            "date_of_birth" =>'1/1/2000',
            "phone" =>rand(1000000,5000000),
            "user_role_id" =>'1',
            "password" =>bcrypt('admin1'),
        ]);
        User::create([
            "user_name" =>'Owner 1',
            "gender"=>'2',
            "email" =>'owner1@gmail.com',
            "date_of_birth" =>'1/1/2000',
            "phone" =>rand(1000000,5000000),
            "user_role_id" =>'3',
            "password" =>bcrypt('owner1'),
        ]);
        User::create([
            "user_name" =>'Owner 2',
            "gender"=>'1',
            "email" =>'owner2@gmail.com',
            "date_of_birth" =>'1/1/2000',
            "phone" =>rand(1000000,5000000),
            "user_role_id" =>'3',
            "password" =>bcrypt('owner2'),
        ]);
        User::create([
            "user_name" =>'Owner 3',
            "gender"=>'2',
            "email" =>'owner3@gmail.com',
            "date_of_birth" =>'1/1/2000',
            "phone" =>rand(1000000,5000000),
            "user_role_id" =>'3',
            "password" =>bcrypt('owner3'),
        ]);
        User::create([
            "user_name" =>'Owner 4',
            "gender"=>'1',
            "email" =>'owner4@gmail.com',
            "date_of_birth" =>'1/1/2000',
            "phone" =>rand(1000000,5000000),
            "user_role_id" =>'3',
            "password" =>bcrypt('owner4'),
        ]);
        User::create([
            "user_name" =>'Tenant  1',
            "gender"=>'1',
            "email" =>'tenant1@gmail.com',
            "date_of_birth" =>'1/1/2000',
            "phone" =>rand(1000000,5000000),
            "user_role_id" =>'2',
            "password" =>bcrypt('tenant1'),
        ]);
        User::create([
            "user_name" =>'Tenant  2',
            "gender"=>'2',
            "email" =>'tenant2@gmail.com',
            "date_of_birth" =>'1/1/2000',
            "phone" =>rand(1000000,5000000),
            "user_role_id" =>'3',
            "password" =>bcrypt('tenant2'),
        ]);
        User::create([
            "user_name" =>'Tenant  3',
            "gender"=>'2',
            "email" =>'tenant3@gmail.com',
            "date_of_birth" =>'1/1/2000',
            "phone" =>rand(1000000,5000000),
            "user_role_id" =>'2',
            "password" =>bcrypt('tenant3'),
        ]);
        User::create([
            "user_name" =>'Tenant 4',
            "gender"=>'1',
            "email" =>'tenant4@gmail.com',
            "date_of_birth" =>'1/1/2000',
            "phone" =>rand(1000000,5000000),
            "user_role_id" =>'2',
            "password" =>bcrypt('tenant4'),
        ]);
        User::create([
            "user_name" =>"asd asd",
            "gender" => "male",
            "email" => "asdasd@gmail.com",
            "date_of_birth" => "2023-04-07",
            "phone" => "0813371337",
            "user_role_id" => "2",
            "password" => bcrypt("asdasd"),
        ]);
        User::create([
            "user_name" =>'Manager 1',
            "gender"=>'1',
            "email" =>'manager1@gmail.com',
            "date_of_birth" =>'1/1/2000',
            "phone" =>rand(1000000,5000000),
            "user_role_id" =>'4',
            "password" =>bcrypt('manager1'),
        ]);
        User::create([
            "user_name" =>'manager  4',
            "gender"=>'1',
            "email" =>'Manager4gmail.com',
            "date_of_birth" =>'1/1/2000',
            "phone" =>rand(1000000,5000000),
            "user_role_id" =>'4',
            "password" =>bcrypt('manager4'),
        ]);
        User::create([
            "user_name" =>'Manager  2',
            "gender"=>'1',
            "email" =>'manager2@gmail.com',
            "date_of_birth" =>'1/1/2000',
            "phone" =>rand(1000000,5000000),
            "user_role_id" =>'4',
            "password" =>bcrypt('manager2'),
        ]);
    }
}
