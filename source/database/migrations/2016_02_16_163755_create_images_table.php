<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImagesTable extends Migration {

	public function up()
	{
		Schema::create('images', function(Blueprint $table) {
			$table->timestamps();
			$table->increments('id');
			$table->string('title', 255);
			$table->string('name', 255)->unique();
			$table->string('description', 255);
			$table->integer('article_id')->unsigned()->index();
		});
	}

	public function down()
	{
		Schema::drop('images');
	}
}