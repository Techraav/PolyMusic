<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('department')->references('id')->on('departments')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('level')->references('id')->on('levels')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('events', function(Blueprint $table) {
			$table->foreign('band')->references('id')->on('bands')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->foreign('author')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('articles', function(Blueprint $table) {
			$table->foreign('author')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('teachers', function(Blueprint $table) {
			$table->foreign('user')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('teachers', function(Blueprint $table) {
			$table->foreign('course')->references('id')->on('courses')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('students', function(Blueprint $table) {
			$table->foreign('user')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('students', function(Blueprint $table) {
			$table->foreign('course')->references('id')->on('courses')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('band_members', function(Blueprint $table) {
			$table->foreign('user')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('band_members', function(Blueprint $table) {
			$table->foreign('band')->references('id')->on('bands')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('band_events', function(Blueprint $table) {
			$table->foreign('band')->references('id')->on('bands')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('band_events', function(Blueprint $table) {
			$table->foreign('event')->references('id')->on('events')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_department_foreign');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_level_foreign');
		});
		Schema::table('events', function(Blueprint $table) {
			$table->dropForeign('events_band_foreign');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->dropForeign('news_author_foreign');
		});
		Schema::table('articles', function(Blueprint $table) {
			$table->dropForeign('articles_author_foreign');
		});
		Schema::table('teachers', function(Blueprint $table) {
			$table->dropForeign('teachers_user_foreign');
		});
		Schema::table('teachers', function(Blueprint $table) {
			$table->dropForeign('teachers_course_foreign');
		});
		Schema::table('students', function(Blueprint $table) {
			$table->dropForeign('students_user_foreign');
		});
		Schema::table('students', function(Blueprint $table) {
			$table->dropForeign('students_course_foreign');
		});
		Schema::table('band_members', function(Blueprint $table) {
			$table->dropForeign('band_members_user_foreign');
		});
		Schema::table('band_members', function(Blueprint $table) {
			$table->dropForeign('band_members_band_foreign');
		});
		Schema::table('band_events', function(Blueprint $table) {
			$table->dropForeign('band_events_band_foreign');
		});
		Schema::table('band_events', function(Blueprint $table) {
			$table->dropForeign('band_events_event_foreign');
		});
	}
}