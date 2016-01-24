<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBlacklistTable extends Migration {

	public function up()
	{
		Schema::create('blacklist', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->string('ip', 30);
			$table->string('infos', 255);
		});
	}

	public function down()
	{
		Schema::drop('blacklist');
	}
}