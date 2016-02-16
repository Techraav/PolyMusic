<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModificationsTable extends Migration {

	public function up()
	{
		Schema::create('modifications', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_id')->unsigned();
			$table->string('table', 255);
			$table->string('message', 255);
		});
	}

	public function down()
	{
		Schema::drop('modifications');
	}
}