<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class CreateDefaultRoles extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role();
        $role->name = 'Admin';
        $role->type = Role::ADMIN;
        $role->save();

        $role = new Role();
        $role->name = 'Kierownik projektu';
        $role->type = Role::PROJECT_OWNER;
        $role->save();

        $role = new Role();
        $role->name = 'Wykonawca projektu';
        $role->type = Role::PROJECT_USER;
        $role->save();

        $role = new Role();
        $role->name = 'Obserwator projektu';
        $role->type = Role::PROJECT_READER;
        $role->save();
    }
}
