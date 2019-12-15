<?php

namespace Tests\Unit;

use App\Activity;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\UserActivity;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Tests\AuthenticatedUser;

class UserActivityTest extends AuthenticatedUser
{

    use RefreshDatabase;

    protected function getDataToPostActivity(){
        return [
            'name' => 'Йога',
            'activity_period' => 2
        ];
    }


    // --- GET USER ACTIVITIES---

    /**
     * 
     * @test
     * @return void
     */
    public function getUserActivities_CorrectUser_Success()
    {
        $NUM_OF_ACTIVITIES = 5;
        $this->makeUserAdmin();
        factory(UserActivity::class, $NUM_OF_ACTIVITIES)->create();
        $response = $this->get("/api/users/{$this->user->id}/activities");
        $response->assertStatus(Response::HTTP_OK)->assertJsonCount($NUM_OF_ACTIVITIES, 'data');
    }

    /**
     * 
     * @test
     * @return void
     */
    public function getUserActivities_UserIsNotCorrect_Forbidden()
    {
        $NUM_OF_ACTIVITIES = 5;
        $incorrectUser = factory(\App\User::class)->create();
        factory(UserActivity::class, $NUM_OF_ACTIVITIES)->create();
        $response = $this->get("/api/users/{$incorrectUser->id}/activities");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    // --- / GET USER ACTIVITIES---

    // --- GET USER ACTIVITY ---
    // --- / GET USER ACTIVITY ---

    // --- POST USER ACTIVITY---
    // --- / POST USER ACTIVITY---

    // --- PATCH USER ACTIVITY---
    // --- / PATCH USER ACTIVITY---

    // --- DELETE USER ACTIVITY---
    // --- / DELETE USER ACTIVITY---


}
