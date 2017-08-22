<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::updateOrCreate([
            'email' => 'peter@gmail.com'
        ], [
            'email' => 'peter@gmail.com',
            'name'  => 'peter',
            'password' => bcrypt('123456')
        ]);

        User::updateOrCreate([
            'email' => 'lena@gmail.com'
        ], [
            'email' => 'lena@gmail.com',
            'name'  => 'lena',
            'password' => bcrypt('123456')
        ])->update();
    }
}
