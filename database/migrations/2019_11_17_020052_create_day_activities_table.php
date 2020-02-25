<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('day_activity', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('user_activity_id')
            ->nullable(true)
            ->unsigned();
            
            $table->foreign('user_activity_id')
            ->references('id')->on('user_activities')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            
            $table->boolean('is_done')->default(false);
            $table->timestamp('date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('table_day_activities');
    }
}
