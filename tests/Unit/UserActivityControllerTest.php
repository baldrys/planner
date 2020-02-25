<?php

namespace Tests\Unit;

use App\Activity;
use App\Http\Resources\ActivityResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\UserActivity;
use App\User;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;
use Tests\AppTest;

class UserActivityTest extends AppTest
{
    use RefreshDatabase;

    protected function getDataToPostActivity(){
        return [
            'name' => 'Test activity',
            'activity_period' => 69
        ];
    }

    protected function createIncorrectUser() {
        return factory(User::class)->create();
    }

    protected function createActivityForIncorrectUser() {
        return  factory(UserActivity::class)->create([
            'user_id' => $this->createIncorrectUser()->id
        ]);
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
        $incorrectUser = $this->createIncorrectUser();
        factory(UserActivity::class, $NUM_OF_ACTIVITIES)->create();
        $response = $this->get("/api/users/{$incorrectUser->id}/activities");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function getUserActivities_UserIsAdmin_Success()
    {
        $this->makeUserAdmin();
        $userToCheck = factory(User::class)->create();
        $NUM_OF_ACTIVITIES = 5;
        factory(UserActivity::class, $NUM_OF_ACTIVITIES)->create([
            'user_id' => $userToCheck->id
        ]);
        $response = $this->get("/api/users/{$userToCheck->id}/activities");
        $response->assertStatus(Response::HTTP_OK)->assertJsonCount($NUM_OF_ACTIVITIES, 'data');
    }
    // --- / GET USER ACTIVITIES---

    // --- GET USER ACTIVITY ---
    /**
     * 
     * @test
     * @return void
     */
    public function getUserActivity_CorrectUser_Success()
    {
        $userActivity = factory(UserActivity::class)->create();
        $response = $this->get("/api/users/{$this->user->id}/activities/{$userActivity->activity->id}");
        $activity = Activity::first();
        $response->assertStatus(Response::HTTP_OK)->assertExactJson([
            'data' => (new ActivityResource($activity))->toArray(null)
            ]
        );
    }

    /**
     * 
     * @test
     * @return void
     */
    public function getUserActivity_UserIsAdmin_Success()
    {
        $userActivity = factory(UserActivity::class)->create();
        $response = $this->get("/api/users/{$this->user->id}/activities/{$userActivity->activity->id}");
        $activity = Activity::first();
        $response->assertStatus(Response::HTTP_OK)->assertExactJson([
            'data' => (new ActivityResource($activity))->toArray(null)
            ]
        );
    }

    /**
     * 
     * @test
     * @return void
     */
    public function getUserActivity_InCorrectUser_Forbidden()
    {
        $userActivity = $this->createActivityForIncorrectUser();
        $response = $this->get("/api/users/{$this->user->id}/activities/{$userActivity->activity->id}");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function getUserActivity_ActivityNotCreated_NotFound()
    {
        $ID_OF_NOT_CREATED_ACTIVITY = 69;
        $response = $this->get("/api/users/{$this->user->id}/activities/{$ID_OF_NOT_CREATED_ACTIVITY}");
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
    // --- / GET USER ACTIVITY ---

    // --- POST USER ACTIVITY---
    /**
     * 
     * @test
     * @return void
     */
    public function postActivity_DataCorrect_Created()
    {
        $response = $this->post("/api/users/{$this->user->id}/activities",
            $this->getDataToPostActivity()
        );
        $createdActivity = Activity::first();
        $response->assertStatus(Response::HTTP_OK)->assertExactJson([
            'data' => (new ActivityResource($createdActivity))->toArray(null)
            ]
        );
    }

    // --- POST USER ACTIVITY---
    /**
     * 
     * @test
     * @return void
     */
    public function postActivity_UserIsAdmin_Created()
    {
        $this->makeUserAdmin();
        $userToCheck = $this->createIncorrectUser();
        $response = $this->post("/api/users/{$userToCheck->id}/activities",
            $this->getDataToPostActivity()
        );
        $createdActivity = Activity::first();
        $response->assertStatus(Response::HTTP_OK)->assertExactJson([
            'data' => (new ActivityResource($createdActivity))->toArray(null)
            ]
        );
    }

    /**
     * 
     * @test
     * @return void
     */
    public function postActivity_IncorrectUser_Forbidden()
    {
        $incorrectUser = $this->createIncorrectUser();
        $response = $this->post("/api/users/{$incorrectUser->id}/activities",
            $this->getDataToPostActivity()
        );
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    // --- / POST USER ACTIVITY---

    // --- PATCH USER ACTIVITY---
    /**
     * 
     * @test
     * @return void
     */
    public function patchActivity_DataCorrect_Updated()
    {
        $createdActivity = factory(UserActivity::class)->create()->activity;
        $response = $this->patch("/api/users/{$this->user->id}/activities/{$createdActivity->id}",
            $this->getDataToPostActivity()
        );
        $createdActivity = Activity::first();  
        $response->assertStatus(Response::HTTP_OK)->assertExactJson([
            'data' => (new ActivityResource($createdActivity))->toArray(null)
            ]
        );
    }

    /**
     * 
     * @test
     * @return void
     */
    public function patchActivity_UserIsAdmin_Updated()
    {
        $this->makeUserAdmin();
        $userToCheck = factory(User::class)->create();
        $createdActivity = factory(UserActivity::class)->create([
            'user_id' => $userToCheck->id
        ])->activity;
        $response = $this->patch("/api/users/{$userToCheck->id}/activities/{$createdActivity->id}",
            $this->getDataToPostActivity()
        );
        $createdActivity = Activity::first();  
        $response->assertStatus(Response::HTTP_OK)->assertExactJson([
            'data' => (new ActivityResource($createdActivity))->toArray(null)
            ]
        );
    }

    /**
     * 
     * @test
     * @return void
     */
    public function patchActivity_IncorrectUser_Forbidden()
    {
        $incorrectUser = $this->createIncorrectUser();
        $createdActivity = factory(UserActivity::class)->create([
            'user_id' => $incorrectUser->id
        ])->activity;
        $response = $this->patch("/api/users/{$incorrectUser->id}/activities/{$createdActivity->id}",
            $this->getDataToPostActivity()
        );
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function patchActivity_ActivityForIncorrectUser_Forbidden()
    {
        $createdActivity = $this->createActivityForIncorrectUser();
        $response = $this->patch("/api/users/{$this->user->id}/activities/{$createdActivity->id}",
            $this->getDataToPostActivity()
        );
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function patchActivity_ActivityNotCreated_NotFound()
    {
        $NOT_FOUND_ACTIVITY_ID = 1;
        $response = $this->patch("/api/users/{$this->user->id}/activities/{$NOT_FOUND_ACTIVITY_ID}",
            $this->getDataToPostActivity()
        );
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
    // --- / PATCH USER ACTIVITY---

    // --- DELETE USER ACTIVITY---
    /**
     * 
     * @test
     * @return void
     */
    public function deleteActivity_ActivityCreated_Success()
    {
        $createdActivity = factory(UserActivity::class)->create()->activity;
        $response = $this->delete("/api/users/{$this->user->id}/activities/{$createdActivity->id}");
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function deleteActivity_UserIsAdmin_Success()
    {
        $this->makeUserAdmin();
        $userToCheck = factory(User::class)->create();
        $createdActivity = factory(UserActivity::class)->create([
            'user_id' => $userToCheck->id
        ])->activity;
        $response = $this->delete("/api/users/{$userToCheck->id}/activities/{$createdActivity->id}");
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function deleteActivity_ActivityCreatedIncorrectUser_Forbidden()
    {
        $createdActivity = $this->createActivityForIncorrectUser();
        $response = $this->delete("/api/users/{$this->user->id}/activities/{$createdActivity->id}");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function deleteActivity_ActivityNotCreated_NotFound()
    {
        $NOT_FOUND_ACTIVITY_ID = 1;
        $response = $this->delete("/api/users/{$this->user->id}/activities/{$NOT_FOUND_ACTIVITY_ID}");
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }  
    // --- / DELETE USER ACTIVITY---
}
