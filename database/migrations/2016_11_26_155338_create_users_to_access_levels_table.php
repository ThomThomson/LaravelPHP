<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersToAccessLevelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_to_access_levels', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('userID')->unsigned();
            $table->integer('accesslevelID')->unsigned();
            $table->timestamps();
        });

        Schema::table('users_to_access_levels', function($table) {
            $table->foreign('userID')->references('id')->on('users');
            $table->foreign('accesslevelID')->references('id')->on('access_levels');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_to_access_levels');
    }
}