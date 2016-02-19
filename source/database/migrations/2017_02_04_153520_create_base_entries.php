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
use App\BandMember;
use App\Announcement;
use App\Article;
use App\CourseModification;
use App\News;
use App\Event;
use App\Comment;
use App\UserLearnCourses;
use App\UserTeachCourses;

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
            'name'  => 'band_creator'
            ]);

        // Create level 2 : teacher
        Level::create([
            'level' => 2,
            'name'  => 'professeur'
            ]);

        // Create level 3 : admin
        Level::create([
            'level' => 2,
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


        // Create departement : "autre"
        Department::create([
            'name'      => 'Autre',
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

        // Create user : Webmaster (lvl 10)
        User::create([
            'first_name'    => 'Webmaster',
            'last_name'     => 'Webmaster',
            'email'         => 'webm@ster',
            'school_year'   => 0,
            'department_id' => 1,
            'password'      => bcrypt('webmastercmt'),
            'level'         => 10,
            'slug'          => 'webmaster-webmaster-1'
            ]);

        // Create user : Admin (lvl 2)
        User::create([
            'first_name'    => 'Admin',
            'last_name'     => 'Admin',
            'email'         => 'admin@admin',
            'school_year'   => 0,
            'department_id' => 1,
            'password'      => bcrypt('admincmt'),
            'level'         => 2,
            'slug'          => 'admin-admin-1'
            ]);

        // Create user : Teacher (lvl 1)
        User::create([
            'first_name'    => 'Teacher',
            'last_name'     => 'Teacher',
            'email'         => 'teacher@teacher',
            'school_year'   => 0,
            'department_id' => 1,
            'password'      => bcrypt('teachercmt'),
            'level'         => 1,
            'slug'          => 'teacher-teacher-1'
            ]);

        // Create user : Member (lvl 0)
        User::create([
            'first_name'    => 'Member',
            'last_name'     => 'Member',
            'email'         => 'member@member',
            'school_year'   => 0,
            'department_id' => 1,
            'password'      => bcrypt('membercmt'),
            'level'         => 0,
            'slug'          => 'member-member-1'
            ]);


        //Creation basic instruments :
        $instruments = ['autre', 'guitare', 'piano', 'basse', 'chant', 'flûte', 
        'violon', 'contrebasse', 'clarinette', 'saxophone', 'batterie', 'violoncelle', 
        'guitare électrique', 'flûte traversière', 'trompette', 'cor', 'trombone', 'tuba'];
        $this->create_instrument($instruments);

        // Create Article 'Cours de guitare'
        Article::create([
            'title'     => 'Cours de guitare',
            'subtitle'  => 'Article concernant le cours de guitare',
            'content'   => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam purus tortor, efficitur ut iaculis ut, 
                            tincidunt vel elit. Morbi malesuada ipsum eu fermentum consequat. Duis aliquam, massa et bibendum 
                            facilisis, nulla nibh ultricies ante, a rutrum augue tellus quis erat. Curabitur aliquam ipsum gravida, 
                            interdum mauris non, blandit justo. Donec non mollis orci, a accumsan ligula. Nullam quis sapien elementum 
                            neque egestas lacinia</p>',
            'user_id'   => 2,
            'slug'      => 'cours-de-guitare-1'
            
            ]);

        // Create Article 'Cours de piano'
        Article::create([
            'title'     => 'Cours de piano',
            'subtitle'  => 'Article concernant le cours de piano',
            'content'   => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam purus tortor, efficitur ut iaculis ut, 
                            tincidunt vel elit. Morbi malesuada ipsum eu fermentum consequat. Duis aliquam, massa et bibendum 
                            facilisis, nulla nibh ultricies ante, a rutrum augue tellus quis erat. Curabitur aliquam ipsum gravida, 
                            interdum mauris non, blandit justo. Donec non mollis orci, a accumsan ligula. Nullam quis sapien elementum 
                            neque egestas lacinia</p>',
            'user_id'   => 3,
            'slug'      => 'cours-de-piano-2'
            
            ]);

        // Create guitar course
        Course::create([
            'name'       => 'Cours de guitare',
            'day'        => 1,
            'start'      => '18:30:00',
            'end'        => '20:00:00',
            'infos'      => 'Cours de guitare du lundi soir.',
            'slug'       => 'cours-de-guitare-lundi-1',
            'instrument_id' => 2,
            'article_id'    => 1,
            'user_id'       => 2
            ]);

        // Create piano course
        Course::create([
            'name'       => 'Cours de piano',
            'day'        => 3,
            'start'      => '18:30:00',
            'end'        => '20:00:00',
            'infos'      => 'Cours de piano du mardi soir.',
            'slug'       => 'cours-de-piano-mardi-2',
            'instrument_id' => 3,
            'article_id'    => 2,
            'user_id'       => 3
            ]);

        // Create Band 'The Band'
        Band::create([
            'name'      => 'The Band', 
            'infos'     => 'premier groupe de test',
            'user_id'   => 1,
            'validated' => 1,
            'slug'      => 'the-band-1'
            ]);

        // Create band 'Second Band'
        Band::create([
            'name'      => 'Second Band', 
            'infos'     => 'deuxieme groupe de test',
            'user_id'   => 2,
            'validated' => 1,
            'slug'      => 'second-band-2'
            ]);

        // Create News 'test news'
        News::create([
            'title'     => 'test news',
            'content'   => '<p>Contenu de la première news de test</p>',
            'user_id'   => 1,
            'slug'      => 'test-news-1'
            ]);

        // Create News 'test second news'
        News::create([
            'title'     => 'test seconde news',
            'content'   => '<p>Contenu de la deuxieme news de test</p>',
            'user_id'   => 2,
            'slug'      => 'test-seconde-news-1'
            ]);

        // Create announcement 'test d'une annonce'
        Announcement::create([
            'user_id'   => 1,
            'title'     => 'test d\'une annonce',
            'slug'      => 'test-annonce-1',
            'validated' => 1,
            'subject'   => 'Annonce pour tester',
            'content'   => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque in malesuada leo.
                            Suspendisse ut dapibus urna. Nunc mattis velit vel varius luctus. Fusce ornare arcu nec odio
                            egestas, et lacinia sapien laoreet. Maecenas odio dui, fringilla non sapien euismod, volutpat 
                            porta sapien. Suspendisse mauris quam, maximus quis tempus non, feugiat in tellus. Sed non quam aliquet, 
                            sollicitudin risus nec, mollis turpis. Donec interdum tincidunt efficitur. Nam efficitur enim a leo 
                            pellentesque, venenatis sollicitudin lacus suscipit. Ut eu nunc eget lacus vehicula gravida. Fusce 
                            vitae ante bibendum, maximus nisl quis, lacinia metus. In pharetra placerat lacus, sed fringilla ex 
                            imperdiet vel. Nulla mollis risus tellus, a ultricies tellus tempor cursus. Quisque viverra nunc ipsum, 
                            a ullamcorper dui porttitor eu. Suspendisse nec nunc ut mi dignissim ultrices.</p>
                            <p>In libero sem, dictum in venenatis sit amet, dictum id quam. Aliquam id ligula luctus, 
                            lobortis felis eget, sollicitudin nulla. Suspendisse tempus aliquet volutpat. Integer lacinia 
                            sem ac libero faucibus cursus. Morbi mauris massa, interdum vel placerat sit amet, rutrum eget 
                            turpis. Mauris convallis semper sem, eu pharetra tortor sagittis non. Praesent auctor justo nulla,
                            in rhoncus ipsum porta ut. Mauris bibendum fringilla accumsan. Proin bibendum eros eros. Aliquam 
                            vulputate, nisi vitae tristique lacinia, leo risus volutpat augue, vel ultricies lorem urna vitae erat. 
                            Vestibulum varius, libero eget sollicitudin luctus, lacus massa molestie purus, quis blandit felis sem at dui.</p>',
            ]);

        // Create announcement 'test d'une seconde annonce'
        Announcement::create([
            'user_id'   => 2,
            'content'   => '<p>contenu de la deuxieme annonce</p>',
            'title'     => 'test d\'une seconde annonce',
            'slug'      => 'test-seconde-annonce-1',
            'validated' => 1,
            'subject'   => 'Deuxieme annonce pour tester',

            ]);

        // Create announcement unvalidated
        Announcement::create([
            'user_id'   => 3,
            'content'   => '<p>azre</p>',
            'title'     => 'azr',
            'slug'      => 'test-annonce-invalidee-1',
            'validated' => 0,
            'subject'   => 'Annonce invalidée pour tester',
            ]);

        // Create comment on announcement #1
        Comment::create([
            'announcement_id'   => 1,
            'user_id'           => 1,
            'content'           => '<p>Nam efficitur enim a leo pellentesque, venenatis sollicitudin lacus suscipit. Ut eu 
                                    nunc eget lacus vehicula gravida. Fusce vitae ante bibendum, maximus nisl quis, lacinia metus. 
                                    In pharetra placerat lacus, sed fringilla ex imperdiet vel. Nulla mollis risus tellus, a ultricies
                                    tellus tempor cursus. Quisque viverra nunc ipsum, a ullamcorper dui porttitor eu. Suspendisse nec
                                    nunc ut mi dignissim ultrices.</p>
                                    <p>In libero sem, dictum in venenatis sit amet, dictum id quam. Aliquam id ligula luctus,
                                     lobortis felis eget, sollicitudin nulla. Suspendisse tempus aliquet volutpat. Integer
                                      lacinia sem ac libero faucibus cursus.</p>'
            ]);

        // Create comment on announcement #1
        Comment::create([
            'announcement_id'   => 1,
            'user_id'           => 2,
            'content'           => '<p>In libero sem, dictum in venenatis sit amet, dictum id quam. Aliquam id ligula luctus,
                                    lobortis felis eget, sollicitudin nulla. Suspendisse tempus aliquet volutpat. Integer
                                    lacinia sem ac libero faucibus cursus.</p>
                                    <p>Nam efficitur enim a leo pellentesque, venenatis sollicitudin lacus suscipit. Ut eu 
                                    nunc eget lacus vehicula gravida. Fusce vitae ante bibendum, maximus nisl quis, lacinia metus. 
                                    In pharetra placerat lacus, sed fringilla ex imperdiet vel. Nulla mollis risus tellus, a ultricies
                                    tellus tempor cursus. Quisque viverra nunc ipsum, a ullamcorper dui porttitor eu. Suspendisse nec
                                    nunc ut mi dignissim ultrices.</p>'
            ]);

        // Create comment on announcement #2
        Comment::create([
            'announcement_id'   => 2,
            'user_id'           => 1,
            'content'           => '<p>commentaire annonce 2</p>'
            ]);

        // Create Article 'premier article'
        Article::create([
            'title'     => 'premier article',
            'subtitle'  => 'test d\'un premier article',
            'content'   => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam purus tortor, efficitur ut iaculis ut, 
                            tincidunt vel elit. Morbi malesuada ipsum eu fermentum consequat. Duis aliquam, massa et bibendum 
                            facilisis, nulla nibh ultricies ante, a rutrum augue tellus quis erat. Curabitur aliquam ipsum gravida, 
                            interdum mauris non, blandit justo. Donec non mollis orci, a accumsan ligula. Nullam quis sapien elementum 
                            neque egestas lacinia</p>',
            'user_id'   => 1,
            'slug'      => 'premier-article-3'
            
            ]);

        // Create Article 'deuxieme article'
        Article::create([
            'title'     => 'deuxieme article',
            'subtitle'  => 'test d\'un deuxieme article',
            'content'   => '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam purus tortor, efficitur ut iaculis ut, 
                            tincidunt vel elit. Morbi malesuada ipsum eu fermentum consequat. Duis aliquam, massa et bibendum 
                            facilisis, nulla nibh ultricies ante, a rutrum augue tellus quis erat. Curabitur aliquam ipsum gravida, 
                            interdum mauris non, blandit justo. Donec non mollis orci, a accumsan ligula. Nullam quis sapien elementum 
                            neque egestas lacinia</p>',
            'user_id'   => 2,
            'slug'      => 'deuxieme-article-4'
            ]);

        // Create Event 'concert de The Band'
        Event::create([
            'location'  => '23 avenue du club musique',
            'day'       => 6,
            'start'     => '18:00:00',
            'end'       => '00:00:00',
            'infos'     => 'infos du premier event',
            'name'      => 'Concert de The Band',
            'slug'      => 'concert-the-band'
            ]);

        // Create Event 'concert de ouf'
        Event::create([
            'location'  => '186 avenue du club musique',
            'day'       => 5,
            'start'     => '17:00:00',
            'end'       => '23:00:00',
            'infos'     => 'infos du deuxieme event',
            'name'      => 'Concert de ouf',
            'slug'      => 'concert-de-ouf'
            ]);

        // Associate Band 1 to Event 1
        BandEvent::create([
            'band_id'   => 1,
            'event_id'  => 1
            ]);

        // Associate band 1 to event 2
        BandEvent::create([
            'band_id'   => 1,
            'event_id'  => 2
            ]);

        // Associate band 2 to event 2
        BandEvent::create([
            'band_id'   => 2,
            'event_id'  => 2
            ]);


        // Associate Members to Bands
        BandMember::create([ 'user_id'   => 1,  'band_id'   => 1, 'instrument_id'   => 1]);
        BandMember::create([ 'user_id'   => 2,  'band_id'   => 1, 'instrument_id'   => 2]);
        BandMember::create([ 'user_id'   => 3,  'band_id'   => 1, 'instrument_id'   => 3]);

        BandMember::create([ 'user_id'   => 2,  'band_id'   => 2, 'instrument_id'   => 5]);
        BandMember::create([ 'user_id'   => 3,  'band_id'   => 2, 'instrument_id'   => 10]);


        // Associate Users to Courses as Students
        UserLearnCourses::create([ 'user_id'    => '1', 'course_id'     => 1, 'validated' => 1]);
        UserLearnCourses::create([ 'user_id'    => '3', 'course_id'     => 1, 'validated' => 1]);
        UserLearnCourses::create([ 'user_id'    => '1', 'course_id'     => 2, 'validated' => 1]);
        UserLearnCourses::create([ 'user_id'    => '4', 'course_id'     => 2, 'validated' => 0]);

        // Associate Users to Courses as Teachers
        UserTeachCourses::create([ 'user_id'    => '3', 'course_id'     => 1, 'validated' => 1]);
        UserTeachCourses::create([ 'user_id'    => '2', 'course_id'     => 1, 'validated' => 1]);
        UserTeachCourses::create([ 'user_id'    => '2', 'course_id'     => 2, 'validated' => 1]);
        UserTeachCourses::create([ 'user_id'    => '4', 'course_id'     => 1, 'validated' => 0]);

        // Course Modification tests
        CourseModification::create([
            'author_id'  => 1,
            'user_id'    => 1,
            'course_id'  => 1,
            'value'      => 0
            ]);

        CourseModification::create([
            'author_id'  => 2,
            'user_id'    => 2,
            'course_id'  => 1,
            'value'      => 1
            ]);

        CourseModification::create([
            'author_id'  => 1,
            'user_id'    => 3,
            'course_id'  => 2,
            'value'      => 2
            ]);

        CourseModification::create([
            'author_id'  => 3,
            'user_id'    => 2,
            'course_id'  => 2,
            'value'      => 3
            ]);

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
