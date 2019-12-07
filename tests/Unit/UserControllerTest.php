<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;


class UserControllerTest extends TestCase
{

    use RefreshDatabase;


    // --- GET USER ---

    /**
     * 
     * @test
     * @return void
     */
    public function getUser_CorrectUser_Success()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->get("/api/users/{$user->id}");
        $response->assertStatus(Response::HTTP_OK)->assertExactJson([
            'data' => (new UserResource($user))->toArray(null)
            ]
        );
    }

    /**
     * 
     * @test
     * @return void
     */
    public function getUser_IncorrectUser_Forbidden()
    {
        $currentUser = factory(User::class)->create();
        $user = factory(User::class)->create();
        $response = $this->actingAs($currentUser, 'api')->get("/api/users/{$user->id}");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function getUser_UserNotCreated_NotFound()
    {
        $ID_OF_NOT_CREATED_USER = 2;
        $currentUser = factory(User::class)->create();
        $response = $this->actingAs($currentUser, 'api')->get("/api/users/{$ID_OF_NOT_CREATED_USER}");
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    // --- / GET USER ---


    // --- POST USER ---

    // --- / POST USER ---


    // --- PATCH USER ---

    // --- / PATCH USER ---

    // --- DELETE USER ---

    // --- / DELETE USER ---

    // --- GET USERS ---

    // --- / GET USERS ---


}
