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
			$table->string('slug', 255)->index();
			$table->integer('instrument_id')->unsigned()->index();
			$table->integer('article_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index();
			$table->tinyInteger('active')->index()->default(1);
		});
	}

	public function down()
	{
		Schema::drop('courses');
	}
}