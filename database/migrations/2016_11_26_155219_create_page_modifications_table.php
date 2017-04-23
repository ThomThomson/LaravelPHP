<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageModificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_modifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('modifiedBy')->unsigned();
            $table->integer('pageModified')->unsigned();
            $table->timestamps();
        });

        Schema::table('page_modifications', function($table) {
            $table->foreign('modifiedBy')->references('id')->on('users');
            $table->foreign('pageModified')->references('id')->on('pages');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('page_modifications');
    }
}