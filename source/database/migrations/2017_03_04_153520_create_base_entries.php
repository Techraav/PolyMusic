<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Level;
use App\User;
use App\Department;
use App\Instrument;
use App\Course;
use App\Band;
use App\BandEvent;
use App\BandUser;
use App\Announcement;
use App\Article;
use App\CourseModification;
use App\News;
use App\Event;
use App\Comment;
use App\CourseUser;
use App\Category;

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
            'name'  => 'membre'
            ]);

        // Create level 1 : band_creator
        Level::create([
            'level' => 1,
            'name'  => 'manager'
            ]);

        // Create level 2 : teacher
        Level::create([
            'level' => 2,
            'name'  => 'professeur'
            ]);

        // Create level 3 : admin
        Level::create([
            'level' => 3,
            'name'  => 'admin'
            ]);

        // Create level 10 : webmaster
        Level::create([
            'level' => 10,
            'name'  => 'webmaster',
            ]);

        // Create departement : "aucun"
        Department::create([
            'name'      => 'Aucun',
            'short_name'=> 'Aucun',
            ]);

        // Create user : Webmaster (lvl 10)
        User::create([
            'first_name'    => 'Webmaster',
            'last_name'     => 'Webmaster',
            'email'         => 'webm@ster',
            'school_year'   => 0,
            'department_id' => 1,
            'password'      => bcrypt('webmastercmt'),
            'level_id'      => 5,
            'slug'          => 'webmaster-webmaster-1'
            ]);

        Category::create(['name' => 'Aucune']);
        Category::create(['name' => 'Autre']);
        Category::create(['name' => 'Présentation']);
        Category::create(['name' => 'Création de groupe']);
        Category::create(['name' => 'Recherche de groupe']);
        Category::create(['name' => 'Échange/Vente']);


        //Creation basic instruments :
        $instruments = ['autre', 'guitare', 'piano', 'basse', 'chant', 'flûte', 
        'violon', 'contrebasse', 'clarinette', 'saxophone', 'batterie', 'violoncelle', 
        'guitare électrique', 'flûte traversière', 'trompette', 'cor', 'trombone', 'tuba'];
        $this->create_instrument($instruments);
    }

    /**
    * Create Instuments in $data
    * @param $data : array containing basic instruments to create
    * @return void
    */
    protected function create_instrument(array $data)
    {
        if($data != []){
            foreach ($data as $d) {
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
