<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateEmailsTable extends Migration {

	public function up()
	{
		Schema::create('emails', function(Blueprint $table) {
            $table->engine = 'InnoDB';

			$table->increments('id');
			$table->timestamps();
			$table->string('sender_email', 255);
			$table->string('subject', 255);
			$table->text('content');
			$table->integer('receiver_id')->unsigned();
			$table->integer('sender_id')->unsigned()->default('0');
		});
	}

	public function down()
	{
		Schema::drop('emails');
	}
}