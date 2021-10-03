<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSensorLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sensor_logs', function (Blueprint $table) {
            $table->id();
            $table->string("message");
            $table->longText("context");
            $table->integer("level");
            $table->string("level_name");
            $table->string("channel");
            $table->dateTime("record_datetime");
            $table->longText("extra");
            $table->string("remote_address")->nullable();
            $table->string("user_agent")->nullable();
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
        Schema::dropIfExists('sensor_logs');
    }
}
