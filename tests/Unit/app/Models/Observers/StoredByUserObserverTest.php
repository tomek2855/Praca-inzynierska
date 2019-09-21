<?php

namespace Tests\Unit;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class StoredByUserObserverTest extends TestCase
{
    public function testFileAuditableTest()
    {
        $user = factory(User::class)->create();
        Auth::login($user);

        $file = factory(File::class)->make();

        $this->assertNull($file->created_by);
        $this->assertNull($file->updated_by);

        $file->save();

        $this->assertInstanceOf(User::class, $file->createdBy);
        $this->assertInstanceOf(User::class, $file->updatedBy);

        $this->assertEquals($user->id, $file->createdBy->id);
        $this->assertEquals($user->id, $file->updatedBy->id);
    }
}
