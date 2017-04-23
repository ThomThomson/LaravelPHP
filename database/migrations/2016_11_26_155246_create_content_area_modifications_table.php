<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentAreaModificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_area_modifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('modifiedBy')->unsigned();
            $table->integer('contentAreaModified')->unsigned();
            $table->timestamps();
        });

        Schema::table('content_area_modifications', function($table) {
            $table->foreign('modifiedBy')->references('id')->on('users');
            $table->foreign('contentAreaModified')->references('id')->on('content_areas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('content_area_modifications');
    }
}