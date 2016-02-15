<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDepartmentsTable extends Migration {

	public function up()
	{
		Schema::create('departments', function(Blueprint $table) {
            $table->engine = 'InnoDB';
			
			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255)->unique();
			$table->string('short_name', 30)->unique();
		});
	}

	public function down()
	{
		Schema::drop('departments');
	}
}