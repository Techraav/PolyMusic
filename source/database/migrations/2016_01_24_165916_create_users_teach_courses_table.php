<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTeachCoursesTable extends Migration {

	public function up()
	{
		Schema::create('users_teach_courses', function(Blueprint $table) {
			$table->timestamps();
			$table->integer('user_id')->unsigned();
			$table->integer('course_id')->unsigned();
			$table->date('date');
			$table->text('message');
			$table->tinyInteger('validated')->default('0');
		});
	}

	public function down()
	{
		Schema::drop('users_teach_courses');
	}
}