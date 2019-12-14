<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Http\Resources\UserResource;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Hash;


class UserActivityTest extends UserAuthenticated
{

    use RefreshDatabase;

    protected function getDataToPostActivity(){
        return [
            'name' => 'Йога',
            'activity_period' => 2
        ];
    }
    // --- GET USER ACTIVITIES---
    
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
