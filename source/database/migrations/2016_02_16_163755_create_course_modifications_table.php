<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseModificationsTable extends Migration {

	public function up()
	{
		Schema::create('course_modifications', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('author_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->integer('course_id')->unsigned();
			$table->string('message', 255);
			$table->tinyInteger('value')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('course_modifications');
	}
}