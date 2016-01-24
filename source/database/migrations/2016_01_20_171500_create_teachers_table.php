<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTeachersTable extends Migration {

	public function up()
	{
		Schema::create('teachers', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user')->unsigned();
			$table->integer('course')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('teachers');
	}
}