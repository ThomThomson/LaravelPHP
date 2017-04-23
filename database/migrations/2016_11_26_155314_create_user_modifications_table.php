<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserModificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_modifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('modifiedBy')->unsigned();
            $table->integer('userModified')->unsigned();
            $table->timestamps();
        });

        Schema::table('user_modifications', function($table) {
            $table->foreign('modifiedBy')->references('id')->on('users');
            $table->foreign('userModified')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_modifications');
    }
}