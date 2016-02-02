<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInstrumentsTable extends Migration {

	public function up()
	{
		Schema::create('instruments', function(Blueprint $table) {
            $table->engine = 'InnoDB';

			$table->increments('id');
			$table->string('name', 255)->unique();
		});
	}

	public function down()
	{
		Schema::drop('intruments');
	}
}