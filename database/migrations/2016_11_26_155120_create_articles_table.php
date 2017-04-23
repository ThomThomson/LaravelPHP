<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('title');
            $table->text('description');
            $table->integer('page')->unsigned()->nullable();
            $table->boolean('allPages');
            $table->integer('contentArea')->unsigned()->nullable();
            $table->text('htmlContent');
            $table->integer('createdBy')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('articles', function($table) {
            $table->foreign('page')->references('id')->on('pages');
            $table->foreign('contentArea')->references('id')->on('content_areas');
            $table->foreign('createdBy')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('articles');
    }
}