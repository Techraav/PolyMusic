<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCourseUserTable extends Migration {

	public function up()
	{
		Schema::create('course_user', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('course_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index();
			$table->date('date');
			$table->text('message');
			$table->tinyInteger('validated')->default(0);
			$table->tinyInteger('level')->default(0)->index();
		});
	}

	public function down()
	{
		Schema::drop('course_user');
	}
}