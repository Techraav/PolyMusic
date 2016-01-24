<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBandEventsTable extends Migration {

	public function up()
	{
		Schema::create('band_events', function(Blueprint $table) {
			$table->integer('band_id')->unsigned();
			$table->integer('event_id')->unsigned();
		});
	}

	public function down()
	{
		Schema::drop('band_events');
	}
}