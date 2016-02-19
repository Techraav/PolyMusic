<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCommentsTable extends Migration {

	public function up()
	{
		Schema::create('comments', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('answer_to')->unsigned()->default('0')->index();
			$table->integer('announcement_id')->unsigned()->index();
			$table->integer('user_id')->unsigned()->index();
			$table->text('content');
		});
	}

	public function down()
	{
		Schema::drop('comments');
	}
}