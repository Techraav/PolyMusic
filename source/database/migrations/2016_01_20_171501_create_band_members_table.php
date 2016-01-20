<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBandMembersTable extends Migration {

	public function up()
	{
		Schema::create('band_members', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('user')->unsigned();
			$table->integer('band')->unsigned();
			$table->string('instrument', 255);
		});
	}

	public function down()
	{
		Schema::drop('band_members');
	}
}