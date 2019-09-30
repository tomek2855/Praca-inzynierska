<?php

namespace Tests\Unit;

use App\Models\Project;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class ProjectUserTestTest extends TestCase
{
    public function testProjectsUsersTest()
    {
        $user = factory(User::class)->create();
        Auth::login($user);

        $project = factory(Project::class)->make();
        $project->save();

        $this->assertEmpty($user->projects);
        $this->assertEmpty($project->users);

        $user->projects()->attach($project);

        $this->assertDatabaseHas('project_user', [
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'user_id' => $user->id,
            'project_id' => $project->id,
        ]);
    }
}
