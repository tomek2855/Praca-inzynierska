<?php

namespace Tests\Unit;

use App\Models\File;
use App\Models\Issue;
use App\Models\Project;
use App\Models\User;
use Laravel\Passport\Passport;
use Tests\TestCase;

class StoredByUserObserverTest extends TestCase
{
    public function testFileAuditableTest()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $file = factory(File::class)->make();

        $this->assertNull($file->created_by);
        $this->assertNull($file->updated_by);

        $file->save();

        $this->assertInstanceOf(User::class, $file->createdBy);
        $this->assertInstanceOf(User::class, $file->updatedBy);

        $this->assertEquals($user->id, $file->createdBy->id);
        $this->assertEquals($user->id, $file->updatedBy->id);
    }

    public function testProjectAuditableTest()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $project = factory(Project::class)->make();

        $this->assertNull($project->created_by);
        $this->assertNull($project->updated_by);

        $project->save();

        $this->assertInstanceOf(User::class, $project->createdBy);
        $this->assertInstanceOf(User::class, $project->updatedBy);

        $this->assertEquals($user->id, $project->createdBy->id);
        $this->assertEquals($user->id, $project->updatedBy->id);
    }

    public function testProjectUserAuditableTest()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $project = factory(Project::class)->make();
        $project->save();

        $user->projects()->attach($project);

        $projectUser = $user->projects->first();

        $this->assertInstanceOf(User::class, $projectUser->createdBy);
        $this->assertInstanceOf(User::class, $projectUser->updatedBy);

        $this->assertEquals($user->id, $projectUser->createdBy->id);
        $this->assertEquals($user->id, $projectUser->updatedBy->id);
    }

    public function testIssueAuditableTest()
    {
        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $project = factory(Project::class)->create();

        $user->projects()->attach($project);

        $issue = factory(Issue::class)->make();
        $issue->assigned_user_id = $user->id;
        $issue->project_id = $project->id;
        $issue->save();

        $this->assertInstanceOf(User::class, $issue->createdBy);
        $this->assertInstanceOf(User::class, $issue->updatedBy);

        $this->assertEquals($user->id, $issue->createdBy->id);
        $this->assertEquals($user->id, $issue->updatedBy->id);
    }
}
