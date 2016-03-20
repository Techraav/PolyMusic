<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNotificationsTable extends Migration {

	public function up()
	{
		Schema::create('notifications', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('message', 255);
			$table->integer('user_id')->unsigned()->index();
			$table->tinyInteger('new')->unsigned()->default(1);
			$table->string('link', 255);
		});
	}

	public function down()
	{
		Schema::drop('notifications');
	}
}