<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            ClientSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
            TaskSeeder::class,
            Role_TaskSeeder::class
        ]);
    }
}
