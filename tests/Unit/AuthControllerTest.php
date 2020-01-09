<?php

namespace Tests\Unit;

use App\DayActivity;
use App\UserActivity;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\AppTest;
use App\Http\Resources\DayActivityResource;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use App\Support\ConfigFile;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function getDataToPostUser(){
        return [
            'name' => 'Pasha69',
            'email' => 'redkva@gmail.com',
            'password' => "secret",
        ];
    }

    public function setUp() :void {
        parent::setUp();
        \Artisan::call('passport:install',['-vvv' => true]);
        $propertyName = 'PASSPORT_CLIENT_SECRET';
        $fileName = realpath(__DIR__ . DIRECTORY_SEPARATOR . '/../../') . '/.env.testing';;
        $ID = 2;
        $code = DB::table('oauth_clients')->where('id', $ID)->first()->secret;
        ConfigFile::writePropertyToEnv($propertyName, $code, $fileName);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function registerUser_DataCorrect_UserRegistered()
    {
        $userDataToRegister = $this->getDataToPostUser();
        $response = $this->post("/api/register",
            $userDataToRegister
        );
        $user = User::where('email', $userDataToRegister['email'])->first();
        $response->assertStatus(Response::HTTP_CREATED)->assertExactJson([
            'data' => (new UserResource($user))->toArray(null)
            ]
        );
    }

    /**
     * 
     * @test
     * @return void
     */
    public function registerUser_EmailAlreadyExists_Forbidden()
    {
        $user = factory(User::class)->create($this->getDataToPostUser());
        $response = $this->post("/api/register",
            $this->getDataToPostUser()
        );
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

}
