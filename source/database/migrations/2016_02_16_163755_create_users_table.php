<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
			$table->increments('id');
			$table->string('email', 255)->unique();
			$table->string('password', 60);
			$table->string('first_name', 255);
			$table->string('last_name', 255);
			$table->date('birth_date');
			$table->string('phone', 12);
			$table->string('profil_picture', 255)->default('base_profil_picture.png');
			$table->text('description');
			$table->integer('school_year')->index();
			$table->integer('department_id')->unsigned()->index();
			$table->string('slug', 255)->index();
			$table->integer('level_id')->unsigned()->index()->default('1');
			$table->tinyInteger('banned')->default('0')->index();
			$table->rememberToken('rememberToken');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}