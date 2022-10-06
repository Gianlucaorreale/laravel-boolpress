<?php

use App\User;
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
        $user = new User();
        $user->name = "gianlucacorreale";
        $user->email = "gianluca.correale@boolean.it";
        $user->password = bcrypt("2ottobre1996");
        $user->save();
    }
}
