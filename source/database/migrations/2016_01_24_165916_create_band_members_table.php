<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateBandMembersTable extends Migration {

	public function up()
	{
		Schema::create('band_members', function(Blueprint $table) {
            $table->engine = 'InnoDB';
            
			$table->integer('user_id')->unsigned()->index();
			$table->integer('band_id')->unsigned()->index();
			$table->string('instrument', 255);
		});
	}

	public function down()
	{
		Schema::drop('band_members');
	}
}