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
        $this->call(CreateDefaultRoles::class);
        $this->call(CreateAdminUser::class);
        $this->call(AddAdminRoleToFirstUser::class);
    }
}
