<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use App\Support\Enums\UserRoleEnum;


class UserAuthenticated extends TestCase
{

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