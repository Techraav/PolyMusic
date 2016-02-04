<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Level;
use App\User;
use App\Department;
use App\Instrument;
use App\Course;

class CreateBaseEntries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Create level 0 : member
        Level::create([
            'level' => 0,
            'name'  => 'member'
            ]);

        // Create level 1 : teacher
        Level::create([
            'level' => 1,
            'name'  => 'professeur'
            ]);

        // Create level 2 : admin
        Level::create([
            'level' => 2,
            'name'  => 'admin'
            ]);

        // Create level 10 : webmaster
        Level::create([
            'level' => 10,
            'name'  => 'webmaster',
            ]);

        // Create departement : "autre"
        Department::create([
            'name'      => 'autre',
            'short_name'=> 'PeiP',
            ]);

        // Create departement : DI
        Department::create([
            'name'      => 'Département Informatique',
            'short_name'=> 'DI',
            ]);

        // Create departement : DMS
        Department::create([
            'name'      => 'Département Mécanique',
            'short_name'=> 'DMS',
            ]);

        //Creation basic instruments :
        $instruments = ['autre', 'guitare', 'piano', 'basse', 'chant', 'flûte', 
        'violon', 'contrebasse', 'clarinette', 'saxophone', 'batterie', 'violoncelle', 
        'guitare électrique', 'flûte traversière', 'trompette', 'cor', 'trombone', 'tuba'];
        $this->create_instrument($instruments);


        // Create guitar course
        Course::create([
            'name'       => 'Cours de guitare',
            'day'        => 1,
            'start'      => '18:30:00',
            'end'        => '20:00:00',
            'infos'      => 'Cours de guitare du lundi soir.',
            'slug'       => 'cours-de-guitare-lundi-1',
            'instrument' => '2',
            ]);

        // Create piano course
        Course::create([
            'name'       => 'Cours de piano',
            'day'        => 3,
            'start'      => '18:30:00',
            'end'        => '20:00:00',
            'infos'      => 'Cours de piano du mardi soir.',
            'slug'       => 'cours-de-piano-mardi-2',
            'instrument' => '3',
            ]);

        // Create user : Webmaster (lvl 10)
        User::create([
            'first_name'    => 'Webmaster',
            'last_name'     => 'Webmaster',
            'email'         => 'webm@ster',
            'school_year'   => 0,
            'department_id' => 1,
            'password'      => bcrypt('webmastercmt'),
            'level'         => 10,
            'slug'          => 'webmaster-webmaster-1',
        ]);
    }

    /**
    * Create Instuments in $data
    * @param $data : array containing basic instruments to create
    * @return void
    */
    protected function create_instrument(array $data)
    {
        if($data != [])
        {
            foreach ($data as $d) 
            {
                Instrument::create([
                    'name' => $d
                    ]);
            }
        }
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
