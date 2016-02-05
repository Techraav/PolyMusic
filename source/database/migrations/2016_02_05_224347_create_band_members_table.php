<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBandMembersTable extends Migration {

	public function up()
	{
		Schema::create('band_members', function(Blueprint $table) {
			$table->integer('user_id')->unsigned();
			$table->integer('band_id')->unsigned();
			$table->integer('instrument_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('band_members');
	}
}