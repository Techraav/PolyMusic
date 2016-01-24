<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateStudentsTable extends Migration {

	public function up()
	{
		Schema::create('students', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user')->unsigned();
			$table->integer('course')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('students');
	}
}