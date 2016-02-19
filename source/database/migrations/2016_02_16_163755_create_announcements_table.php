<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAnnouncementsTable extends Migration {

	public function up()
	{
		Schema::create('announcements', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user_id')->unsigned()->index();
			$table->string('title', 255);
			$table->text('content');
			$table->string('tags', 255);
			$table->string('slug', 255)->index();
			$table->tinyInteger('validated')->default('1');
			$table->string('subject', 255);
			$table->integer('category_id')->index()->unsigned()->default(1);
		});
	}

	public function down()
	{
		Schema::drop('announcements');
	}
}