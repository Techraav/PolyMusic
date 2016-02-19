<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBandEventTable extends Migration {

	public function up()
	{
		Schema::create('band_event', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('band_id')->unsigned()->index();
			$table->integer('event_id')->unsigned()->index();
		});
	}

	public function down()
	{
		Schema::drop('band_event');
	}
}