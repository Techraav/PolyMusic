<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateArticlesTable extends Migration {

	public function up()
	{
		Schema::create('articles', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title', 255);
			$table->string('subtitle', 255);
			$table->text('content');
			$table->integer('user_id')->unsigned()->index();
			$table->string('slug', 255)->index();
			$table->integer('category_id')->index()->unsigned()->default(1);
		});
	}

	public function down()
	{
		Schema::drop('articles');
	}
}