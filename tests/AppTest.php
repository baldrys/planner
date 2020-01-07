<?php

namespace Tests;

// use Tests\TestCase;
use App\User;
use App\Support\Enums\UserRoleEnum;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

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





}