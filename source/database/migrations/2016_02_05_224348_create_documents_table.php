<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDocumentsTable extends Migration {

	public function up()
	{
		Schema::create('documents', function(Blueprint $table) {
            $table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->timestamps();
			$table->string('title', 255);
			$table->string('name', 255);
			$table->integer('user_id')->unsigned();
			$table->text('description');
			$table->integer('course_id')->unique()->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('documents');
	}
}