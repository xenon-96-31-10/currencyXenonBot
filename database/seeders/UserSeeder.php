<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      //Администратор
      $user = new User();
      $user->login = "admin";
      $user->role = "admin";
      $user->email = "admin@curriencybot.ru";
      $user->password = bcrypt('admin');
      $user->save();
    }
}
