<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDayActivityTable extends Migration
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

            $table->unsignedBigInteger('user_id')
            ->nullable(true)
            ->unsigned();
            $table->foreign('user_id')
            ->references('id')->on('users')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->unsignedBigInteger('activity_id')
            ->nullable(true)
            ->unsigned();
            $table->foreign('activity_id')
            ->references('id')->on('activities')
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
        Schema::dropIfExists('day_activity');
    }
}
