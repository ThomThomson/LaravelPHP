<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('alias');
            $table->text('description');
            $table->integer('createdBy')->unsigned()->nullable();
            //$table->integer('modifiedBy')->unsigned();
            $table->timestamps();
        });

        Schema::table('pages', function($table) {
            $table->foreign('createdBy')->references('id')->on('users');
            //$table->foreign('modifiedBy')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('pages');
    }
}