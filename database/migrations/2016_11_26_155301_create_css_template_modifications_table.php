<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCssTemplateModificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('css_template_modifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('modifiedBy')->unsigned();
            $table->integer('cssTemplateModified')->unsigned();
            $table->timestamps();
        });

        Schema::table('css_template_modifications', function($table) {
            $table->foreign('modifiedBy')->references('id')->on('users');
            $table->foreign('cssTemplateModified')->references('id')->on('css_templates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('css_template_modifications');
    }
}