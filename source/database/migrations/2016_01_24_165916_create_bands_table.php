<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBandsTable extends Migration {

	public function up()
	{
		Schema::create('bands', function(Blueprint $table) {
            $table->engine = 'InnoDB';

			$table->increments('id');
			$table->timestamps();
			$table->string('name', 255)->unique();
			$table->string('image', 255);
			$table->text('infos');
			$table->integer('user_id')->unsigned()->default('0');
			$table->tinyInteger('validated')->default('0');
			$table->string('slug', 255);
		});
	}

	public function down()
	{
		Schema::drop('bands');
	}
}