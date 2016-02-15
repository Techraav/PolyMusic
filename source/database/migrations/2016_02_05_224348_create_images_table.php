<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateImagesTable extends Migration {

	public function up()
	{
		Schema::create('images', function(Blueprint $table) {
            $table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->string('title', 255);
			$table->text('description');
			$table->integer('article_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('images');
	}
}