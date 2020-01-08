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

class AuthControllerTest extends AppTest
{
    use RefreshDatabase;

    public function setUp() :void {
        parent::setUp();
        \Artisan::call('passport:install',['-vvv' => true]);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function registerUser_DataCorrect_UserRegistered()
    {
        $propertyName = 'PASSPORT_CLIENT_SECRET';
        $fileName = __DIR__ . '/..';
        dd($fileName);
        $ID = 2;
        $code = DB::table('oauth_clients')->where('id', $ID)->first()->secret;
        // ConfigFile::writePropertyToEnv($propertyName, $code, $fileName);
        // $code2 = ConfigFile::getPropertyFromEnv($propertyName, $code, $fileName);
        dd($code, $fileName);
    }

}
