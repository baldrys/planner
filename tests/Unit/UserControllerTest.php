<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;


class UserControllerTest extends UserAuthenticated
{

    use RefreshDatabase;

    protected function getDataToPostUser(){
        return [
            'name' => 'Pasha69',
            'email' => 'redkva@gmail.com',
            'password' => Hash::make('123456'),
        ];
    }

    // --- GET USER ---

    /**
     * 
     * @test
     * @return void
     */
    public function getUser_CorrectUser_Success()
    {
        $response = $this->get("/api/users/{$this->user->id}");
        $user = User::first();
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
        $incorrectUser = factory(User::class)->create();
        $response = $this->get("/api/users/{$incorrectUser->id}");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function getUser_UserNotCreated_NotFound()
    {
        $ID_OF_NOT_CREATED_USER = 69;
        $response = $this->get("/api/users/{$ID_OF_NOT_CREATED_USER}");
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
    // --- / GET USER ---

    // --- POST USER ---
    /**
     * 
     * @test
     * @return void
     */
    public function postUser_DataCorrect_Created()
    {
        $ID_OF_NEW_USER = 2;
        $this->makeUserAdmin();
        $response = $this->post("/api/users/",
            $this->getDataToPostUser()
        );
        $createdUser = User::find($ID_OF_NEW_USER);
        $response->assertStatus(Response::HTTP_CREATED)->assertExactJson([
            'data' => (new UserResource($createdUser))->toArray(null)
            ]
        );
    }

    /**
     * 
     * @test
     * @return void
     */
    public function postUser_UserIsNotAdmin_Forbidden()
    {
        $response = $this->post("/api/users/",
            $this->getDataToPostUser()
        );
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    // --- / POST USER ---

    // --- PATCH USER ---
    /**
     * 
     * @test
     * @return void
     */
    public function patchUser_DataCorrect_Updated()
    {
        $response = $this->patch("/api/users/{$this->user->id}",
            $this->getDataToPostUser()
        );
        $updatedUser = User::first();
        $response->assertStatus(Response::HTTP_OK)->assertExactJson([
            'data' => (new UserResource($updatedUser))->toArray(null)
            ]
        );
    }

    /**
     * 
     * @test
     * @return void
     */
    public function patchUser_IncorrectUser_Forbidden()
    {
        $incorrectUser = factory(User::class)->create();
        $response = $this->patch("/api/users/{$incorrectUser->id}",
            $this->getDataToPostUser()
        );
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function patchUser_UserNotExists_NotFound()
    {
        $ID_OF_NOT_CREATED_USER = 69;
        $response = $this->patch("/api/users/{ $ID_OF_NOT_CREATED_USER}",
            $this->getDataToPostUser()
        );
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
    // --- / PATCH USER ---

    // --- DELETE USER ---
    /**
     * 
     * @test
     * @return void
     */
    public function deleteUser_UserExistsCorrectUser_Success()
    {
        $response = $this->delete("/api/users/{$this->user->id}");
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function deleteUser_UserExistsIncorrectUser_Fail()
    {
        $incorrectUser = factory(User::class)->create();
        $response = $this->delete("/api/users/{$incorrectUser->id}");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function deleteUser_UserNotExists_NotFound()
    {
        $ID_OF_NOT_CREATED_USER = 69;
        $response = $this->delete("/api/users/{$ID_OF_NOT_CREATED_USER}");
        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function deleteUser_UserIsAdminUserExists_Success()
    {
        $this->makeUserAdmin();
        $userToDelete = factory(User::class)->create();
        $response = $this->delete("/api/users/{$userToDelete->id}");
        $response->assertStatus(Response::HTTP_OK);
    }
    // --- / DELETE USER ---

    // --- GET USERS ---
    /**
     * 
     * @test
     * @return void
     */
    public function getUsers_UserIsAdmin_Success()
    {
        $NUM_OF_USERS = 5;
        $this->makeUserAdmin();
        factory(User::class, $NUM_OF_USERS)->create();
        $response = $this->get("/api/users");
        $response->assertStatus(Response::HTTP_OK)->assertJsonCount($NUM_OF_USERS+1, 'data');
    }

    /**
     * 
     * @test
     * @return void
     */
    public function getUsers_UserIsNotAdmin_Forbidden()
    {
        $NUM_OF_USERS = 5;
        factory(User::class, $NUM_OF_USERS)->create();
        $response = $this->get("/api/users");
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }
    // --- / GET USERS ---
}
