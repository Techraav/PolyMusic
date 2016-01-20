<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateLevelsTable extends Migration {

	public function up()
	{
		Schema::create('levels', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('level')->unique();
			$table->string('name', 255)->unique();
			$table->text('infos');
		});
	}

	public function down()
	{
		Schema::drop('levels');
	}
}