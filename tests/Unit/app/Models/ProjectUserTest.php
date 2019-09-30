<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProjectUserTestTest extends TestCase
{
    public function testFileAuditableTest()
    {
        $user = factory(User::class)->create();
        Auth::login($user);

        $project = factory(Project::class)->make();
        $project->save();

        $this->assertEmpty($user->projects);
        $this->assertEmpty($project->users);
    }
}
