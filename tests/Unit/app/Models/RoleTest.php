<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class RoleTest extends TestCase
{
    public function testAdminRoleExistsTest()
    {
        Artisan::call('migrate:fresh');

        $this->assertNull(Role::getAdminRole());

        $this->seed('CreateDefaultRoles');

        $adminRole = Role::getAdminRole();

        $this->assertInstanceOf(Role::class, $adminRole);
        $this->assertStringContainsString(Role::ADMIN, $adminRole->type);
    }

    public function testProjectOwnerRoleExistsTest()
    {
        Artisan::call('migrate:fresh');

        $this->assertNull(Role::getProjectOwnerRole());

        $this->seed('CreateDefaultRoles');

        $projectOwnerRole = Role::getProjectOwnerRole();

        $this->assertInstanceOf(Role::class, $projectOwnerRole);
        $this->assertStringContainsString(Role::PROJECT_OWNER, $projectOwnerRole->type);
    }

    public function testProjectUserRoleExistsTest()
    {
        Artisan::call('migrate:fresh');

        $this->assertNull(Role::getProjectUserRole());

        $this->seed('CreateDefaultRoles');

        $projectUser = Role::getProjectUserRole();

        $this->assertInstanceOf(Role::class, $projectUser);
        $this->assertStringContainsString(Role::PROJECT_USER, $projectUser->type);
    }

    public function testProjectReaderRoleExistsTest()
    {
        Artisan::call('migrate:fresh');

        $this->assertNull(Role::getProjectReaderRole());

        $this->seed('CreateDefaultRoles');

        $projectReader = Role::getProjectReaderRole();

        $this->assertInstanceOf(Role::class, $projectReader);
        $this->assertStringContainsString(Role::PROJECT_READER, $projectReader->type);
    }

    public function testUserHasAdminRolesTest()
    {
        $user = factory(User::class)->make();
        $user->save();

        $this->assertFalse($user->isAdmin());

        $user->setAdmin();

        $this->assertTrue($user->isAdmin());

        $user->setAdmin(false);

        $this->assertFalse($user->isAdmin());
    }
}