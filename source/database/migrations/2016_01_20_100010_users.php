<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Users extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->date('birth_date');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->string('image');
            $table->text('summary');
            $table->foreign('band')->references('id')->on('bands')->default(0);
            $table->string('band-instru');
            $table->integer('scholl_year');
            $table->string('department')->references('id')->on('departments');
            $table->strin('slug');
            $table->foreign('level')->references('id')->on('levels');
            $table->boolean('banned');
            $table->string('cours')->references('id')->on('courses');
            $table->text('teacher');
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
        Schema::drop('users');
    }
}
