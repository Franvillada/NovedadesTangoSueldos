<?php

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
        DB::table('users')->insert([
            'username' => 'franvillada',
            'email' => 'franciscovilladaa@gmail.com',
            'password' => Hash::make('1234'),
            'client_id' => 1,
            'role_id' => 1,
            'active' => 1
        ]);
    }
}
