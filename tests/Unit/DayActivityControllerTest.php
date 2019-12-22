<?php

namespace Tests\Unit;

use App\DayActivity;
use App\UserActivity;
use App\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\AppTest;
use App\Http\Resources\DayActivityResource;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DayActivityControllerTest extends AppTest
{
    use RefreshDatabase;

    protected function getDataToGetDayActivities(){
        $startDate = DayActivity::orderBy('date', 'ASC')->first()->date->format('Y-m-d');
        $endDate = DayActivity::orderBy('date', 'DESC')->first()->date->format('Y-m-d');
        return [
            'start_date' => $startDate,
            'end_date' => $endDate
        ];
    }

    // --- GET DAY ACTIVITIES---
    /**
     * 
     * @test
     * @return void
     */
    public function getDayActivities_CorrectUser_Success()
    {
        $PERIOD = 1;
        $TOTAL_DAYS = 7;
        factory(UserActivity::class)->create([
            'activity_period' =>$PERIOD
        ]);

        $lastActivityDay = date('Y-m-d', time() - $TOTAL_DAYS*24*60*60);
        $freeDays = intdiv($TOTAL_DAYS + 1, ($PERIOD + 1));
        $NUM_OF_DAY_ACTIVITIES = $TOTAL_DAYS + 1 - $freeDays;
        factory(DayActivity::class)->create([
            'date' => $lastActivityDay,
            'is_free_day' => 0
        ]);

        $response = $this->json("GET", "/api/users/{$this->user->id}/day-activities",
            [
                'start_date' => $lastActivityDay,
                'end_date' => date('Y-m-d', time())
            ]
        );
        $numOfActivityDays = collect( $response->json()['data']['activities'][0]['day_activities'])->filter(function($item){
            return $item['is_free_day'] == 0;
        })->count();
        $numOfFreeDays= collect( $response->json()['data']['activities'][0]['day_activities'])->filter(function($item){
            return $item['is_free_day'] == 1;
        })->count();
        $this->assertEquals($numOfFreeDays, $freeDays);
        $this->assertEquals($numOfActivityDays, $NUM_OF_DAY_ACTIVITIES);
        $response->assertStatus(Response::HTTP_OK)->assertJsonCount($TOTAL_DAYS + 1, 'data.activities.0.day_activities');
    }

    /**
     * 
     * @test
     * @return void
     */
    public function getDayActivities_InCorrectUser_Forbidden()
    {
        $incorrectUser = factory(User::class)->create();
        $response = $this->json("GET", "/api/users/{$incorrectUser->id}/day-activities",
            [
                'start_date' => date('Y-m-d', time()),
                'end_date' => date('Y-m-d', time())
            ]
        );
        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    /**
     * 
     * @test
     * @return void
     */
    public function getDayActivities_UserIsAdmin_Success()
    {
        $PERIOD = 1;
        $TOTAL_DAYS = 7;
        $this->makeUserAdmin();
        $userToCheck = factory(User::class)->create();
        factory(UserActivity::class)->create([
            'activity_period' =>$PERIOD,
            'user_id' => $userToCheck->id
        ]);

        $lastActivityDay = date('Y-m-d', time() - $TOTAL_DAYS*24*60*60);
        $freeDays = intdiv($TOTAL_DAYS + 1, ($PERIOD + 1));
        $NUM_OF_DAY_ACTIVITIES = $TOTAL_DAYS + 1 - $freeDays;
        factory(DayActivity::class)->create([
            'date' => $lastActivityDay,
            'is_free_day' => 0
        ]);

        $response = $this->json("GET", "/api/users/{$userToCheck->id}/day-activities",
            [
                'start_date' => $lastActivityDay,
                'end_date' => date('Y-m-d', time())
            ]
        );
        $numOfActivityDays = collect( $response->json()['data']['activities'][0]['day_activities'])->filter(function($item){
            return $item['is_free_day'] == 0;
        })->count();
        $numOfFreeDays= collect( $response->json()['data']['activities'][0]['day_activities'])->filter(function($item){
            return $item['is_free_day'] == 1;
        })->count();
        $this->assertEquals($numOfFreeDays, $freeDays);
        $this->assertEquals($numOfActivityDays, $NUM_OF_DAY_ACTIVITIES);
        $response->assertStatus(Response::HTTP_OK)->assertJsonCount($TOTAL_DAYS + 1, 'data.activities.0.day_activities');

    }
    // --- / GET DAY ACTIVITIES---


    // --- PATCH DAY ACTIVITY---

    /**
     * 
     * @test
     * @return void
     */
    public function postDayActivities_InputDataCorrect_Created()
    {
        $IS_DONE = true;
        factory(UserActivity::class)->create();
        $dayActivity = factory(DayActivity::class)->create();
        $response = $this->json("PATCH", "/api/users/{$this->user->id}/day-activities/{$dayActivity->id}",
            [
                'is_done' => $IS_DONE
            ]
        );
        $updatedDayActivity = DayActivity::find($dayActivity->id);
        $response->assertStatus(Response::HTTP_OK)->assertExactJson([
            'data' => (new DayActivityResource($updatedDayActivity))->toArray(null)
            ]
        );
        
    }

    /**
     * 
     * @test
     * @return void
     */
    public function postDayActivities_InputDataCorrectUserIsAdmin_Created()
    {
        $IS_DONE = true;
        $this->makeUserAdmin();
        $userToCheck = factory(User::class)->create();
        factory(UserActivity::class)->create([
            'user_id' => $userToCheck->id
        ]);
        $dayActivity = factory(DayActivity::class)->create();
        $response = $this->json("PATCH", "/api/users/{$userToCheck->id}/day-activities/{$dayActivity->id}",
            [
                'is_done' => $IS_DONE
            ]
        );
        $updatedDayActivity = DayActivity::find($dayActivity->id);
        $response->assertStatus(Response::HTTP_OK)->assertExactJson([
            'data' => (new DayActivityResource($updatedDayActivity))->toArray(null)
            ]
        );
        
    }

    /**
     * 
     * @test
     * @return void
     */
    public function postDayActivities_IncorrectDayActivity_Forbidden()
    {
        $incorrectUser = factory(User::class)->create();
        $IS_DONE = true;
        factory(UserActivity::class)->create([
            'user_id' => $incorrectUser->id
        ]);
        $dayActivity = factory(DayActivity::class)->create();
        $response = $this->json("PATCH", "/api/users/{$this->user->id}/day-activities/{$dayActivity->id}",
            [
                'is_done' => $IS_DONE
            ]
        );
        $response->assertStatus(Response::HTTP_FORBIDDEN);
        
    }

    /**
     * 
     * @test
     * @return void
     */
    public function postDayActivities_IncorrectUser_Forbidden()
    {
        $incorrectUser = factory(User::class)->create();
        $IS_DONE = true;
        factory(UserActivity::class)->create();
        $dayActivity = factory(DayActivity::class)->create();
        $response = $this->json("PATCH", "/api/users/{$incorrectUser->id}/day-activities/{$dayActivity->id}",
            [
                'is_done' => $IS_DONE
            ]
        );
        $response->assertStatus(Response::HTTP_FORBIDDEN);;
        
    }

    /**
     * 
     * @test
     * @return void
     */
    public function postDayActivities_DayActivityNotCreated_NotFound()
    {
        $NOT_CREATED_ID = 69;
        $incorrectUser = factory(User::class)->create();
        $IS_DONE = true;
        $response = $this->json("PATCH", "/api/users/{$incorrectUser->id}/day-activities/{$NOT_CREATED_ID}",
            [
                'is_done' => $IS_DONE
            ]
        );
        $response->assertStatus(Response::HTTP_NOT_FOUND);;
        
    }
    // --- / PATCH DAY ACTIVITY---
}
