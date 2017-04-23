<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleModificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_modifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('modifiedBy')->unsigned();
            $table->integer('articleModified')->unsigned();
            $table->timestamps();
        });

        Schema::table('article_modifications', function($table) {
            $table->foreign('modifiedBy')->references('id')->on('users');
            $table->foreign('articleModified')->references('id')->on('articles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('article_modifications');
    }
}