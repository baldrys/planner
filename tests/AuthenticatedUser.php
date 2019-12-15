<?php

namespace Tests;

// use Tests\TestCase;
use App\User;
use App\Support\Enums\UserRoleEnum;
use Illuminate\Foundation\Testing\TestCase;

abstract class AuthenticatedUser extends TestCase
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

}