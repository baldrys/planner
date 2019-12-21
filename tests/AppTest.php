<?php

namespace Tests;

// use Tests\TestCase;
use App\User;
use App\Support\Enums\UserRoleEnum;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use App\UserActivity;

abstract class AppTest extends TestCase
{
    use CreatesApplication;
    protected $user;

    public function setUp() :void
    {
        parent::setUp();
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');
        $this->user = $user;
    }

    protected function makeUserAdmin(){
        $this->user->role = UserRoleEnum::Admin;
        return $this->user;
    }

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

    protected function getDataToPostUser(){
        return [
            'name' => 'Pasha69',
            'email' => 'redkva@gmail.com',
            'password' => Hash::make('123456'),
        ];
    }

}