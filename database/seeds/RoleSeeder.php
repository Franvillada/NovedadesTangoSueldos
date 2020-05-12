<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['role' => 'superadmin', 'access' => 'total'],
            ['role' => 'admin', 'access' => 'unico'],
            ['role' => 'general', 'access' => 'unico']
        ];
        DB::table('roles')->insert($roles);
    }
}
