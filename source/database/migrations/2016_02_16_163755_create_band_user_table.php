<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBandUserTable extends Migration {

	public function up()
	{
		Schema::create('band_user', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('user_id')->unsigned()->index();
			$table->integer('band_id')->unsigned()->index();
			$table->integer('instrument_id')->unsigned()->index();
		});
	}

	public function down()
	{
		Schema::drop('band_user');
	}
}