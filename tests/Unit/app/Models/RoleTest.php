<?php

namespace Tests\Unit;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class RoleTest extends TestCase
{
    use RefreshDatabase;

    public function testAdminRoleExistsTest()
    {
        $this->refreshDatabase();

        $this->assertNull(Role::getAdminRole());

        $this->seed('CreateDefaultRoles');

        $adminRole = Role::getAdminRole();

        $this->assertInstanceOf(Role::class, $adminRole);
        $this->assertStringContainsString(Role::ADMIN, $adminRole->type);
    }

    public function testProjectOwnerRoleExistsTest()
    {
        $this->refreshDatabase();

        $this->assertNull(Role::getProjectOwnerRole());

        $this->seed('CreateDefaultRoles');

        $projectOwnerRole = Role::getProjectOwnerRole();

        $this->assertInstanceOf(Role::class, $projectOwnerRole);
        $this->assertStringContainsString(Role::PROJECT_OWNER, $projectOwnerRole->type);
    }

    public function testProjectUserRoleExistsTest()
    {
        $this->refreshDatabase();

        $this->assertNull(Role::getProjectUserRole());

        $this->seed('CreateDefaultRoles');

        $projectUser = Role::getProjectUserRole();

        $this->assertInstanceOf(Role::class, $projectUser);
        $this->assertStringContainsString(Role::PROJECT_USER, $projectUser->type);
    }

    public function testProjectReaderRoleExistsTest()
    {
        $this->refreshDatabase();

        $this->assertNull(Role::getProjectReaderRole());

        $this->seed('CreateDefaultRoles');

        $projectReader = Role::getProjectReaderRole();

        $this->assertInstanceOf(Role::class, $projectReader);
        $this->assertStringContainsString(Role::PROJECT_READER, $projectReader->type);
    }

    public function testUserHasAdminRolesTest()
    {
        $this->seed('CreateDefaultRoles');

        $user = factory(User::class)->create();

        $this->assertFalse($user->isAdmin());

        $user->setAdmin();

        $this->assertTrue($user->isAdmin());

        $user->setAdmin(false);

        $this->assertFalse($user->isAdmin());
    }
}