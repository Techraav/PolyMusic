<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	public function up()
	{
		Schema::create('users', function(Blueprint $table) {
            $table->engine = 'InnoDB';

			$table->increments('id');
			$table->string('email', 255)->unique();
			$table->string('password', 60);
			$table->string('first_name', 255);
			$table->string('last_name', 255);
			$table->date('birth_date');
			$table->string('phone', 12);
			$table->string('profil_picture', 255)->default('base_profil_picture.png');
			$table->text('description');
			$table->integer('school_year')->unsigned();
			$table->integer('department_id')->unsigned()->index();
			$table->string('slug', 255)->unique();
			$table->integer('level')->unsigned()->index()->default('0');
			$table->tinyInteger('banned')->default('0');
			$table->rememberToken('rememberToken');
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('users');
	}
}