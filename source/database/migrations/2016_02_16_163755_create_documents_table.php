<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDocumentsTable extends Migration {

	public function up()
	{
		Schema::create('documents', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('title', 255);
			$table->string('name', 255);
			$table->integer('user_id')->unsigned()->index();
			$table->string('description', 255);
			$table->integer('course_id')->index()->unsigned();
			$table->tinyInteger('validated')->index()->unsigned()->default(1);
			
		});
	}

	public function down()
	{
		Schema::drop('documents');
	}
}