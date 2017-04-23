<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCssTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('css_templates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->tinyInteger('active'); //TODO: change to boolean?
            $table->text('cssContent');
            $table->integer('createdBy')->unsigned()->nullable();
            $table->timestamps();
        });

        Schema::table('css_templates', function($table) {
            $table->foreign('createdBy')->references('id')->on('users');
        });
    }

    public function down()
    {
        Schema::drop('css_templates');
    }
}