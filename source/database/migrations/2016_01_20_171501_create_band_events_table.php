<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBandEventsTable extends Migration {

	public function up()
	{
		Schema::create('band_events', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('band')->unsigned();
			$table->integer('event')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('band_events');
	}
}