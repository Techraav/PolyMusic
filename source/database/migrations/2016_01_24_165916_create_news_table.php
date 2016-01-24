<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsTable extends Migration {

	public function up()
	{
		Schema::create('news', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title', 255);
			$table->text('content');
			$table->integer('user_id')->unsigned();
			$table->tinyInteger('active')->default('1');
			$table->string('slug', 255);
		});
	}

	public function down()
	{
		Schema::drop('news');
	}
}