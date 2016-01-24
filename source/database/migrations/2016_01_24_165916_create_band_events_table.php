<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBandEventsTable extends Migration {

	public function up()
	{
		Schema::create('band_events', function(Blueprint $table) {
            $table->engine = 'InnoDB';

			$table->integer('band_id')->unsigned()->index();
			$table->integer('event_id')->unsigned()->index();
		});
	}

	public function down()
	{
		Schema::drop('band_events');
	}
}