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
            "user_name" =>"asd asd",
            "gender" => "male",
            "email" => "asdasd@gmail.com",
            "date_of_birth" => "2023-04-07",
            "phone" => "0813371337",
            "user_role_id" => "2",
            "password" => bcrypt("asdasd"),
        ]);
    }
}
