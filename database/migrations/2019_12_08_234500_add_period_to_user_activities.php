<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPeriodToUserActivities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_activities', function (Blueprint $table) {
            $table->smallInteger('activity_period')->default(1);
            
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['activity_period']);
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_activities', function (Blueprint $table) {
            $table->dropColumn(['activity_period']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->smallInteger('activity_period')->default(1);
        });
    }
}
