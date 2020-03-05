<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;
use App\DayActivity;
use App\Support\DateTime;

class AddTodayActivities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:todayActivities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Команда для добавления сегодняшних активностей';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();
        $today = DateTime::formatDate(time());
        foreach($users as $user) {
            $activities = $user->activities()->get();
            foreach ($activities as $activity) {
                $isFreeDay = $activity->isTodayFreeDay();
                DayActivity::firstOrCreate([
                    'user_activity_id' => $activity->userActivity->id,
                    'date' => $today,
                    'is_free_day' => $isFreeDay,
                    'is_paused' => $activity->is_paused
                ]);      
            }  
        }

    }
}
