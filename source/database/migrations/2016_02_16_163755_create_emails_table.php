<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailsTable extends Migration {

	public function up()
	{
		Schema::create('emails', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('sender_email', 255);
			$table->string('subject', 255);
			$table->text('content');
			$table->integer('receiver_id')->unsigned()->index();
			$table->integer('sender_id')->unsigned()->index()->default('0');
		});
	}

	public function down()
	{
		Schema::drop('emails');
	}
}