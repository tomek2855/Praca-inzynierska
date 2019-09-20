<?php

use Illuminate\Database\Seeder;

class AddAdminRoleToFirstUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::first();
        $user->roles()->attach(1, ['project_id' => null]);
    }
}
