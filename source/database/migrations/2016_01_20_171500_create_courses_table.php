<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCoursesTable extends Migration {

	public function up()
	{
		Schema::create('courses', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255)->unique();
			$table->tinyInteger('day');
			$table->time('start');
			$table->time('end');
			$table->text('infos');
		});
	}

	public function down()
	{
		Schema::drop('courses');
	}
}