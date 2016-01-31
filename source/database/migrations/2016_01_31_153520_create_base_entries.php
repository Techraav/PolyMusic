<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Level;
use App\User;
use App\Department;

class CreateBaseEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Level::create([
            'level' => 0,
            'name'  => 'member'
            ]);

        Level::create([
            'level' => 1,
            'name'  => 'admin',
            ]);

        Department::create([
            'name'      => 'autre',
            'short_name'=> 'PeiP',
            ]);

        User::create([
            'first_name'    => 'Webmaster',
            'last_name'     => 'Webmaster',
            'email'         => 'webm@ster',
            'school_year'   => 0,
            'department_id' => 1,
            'password'      => bcrypt('webm@stercmt'),
            'level'         => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
