<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('department_id')->references('id')->on('departments')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->foreign('level')->references('level')->on('levels')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('courses', function(Blueprint $table) {
			$table->foreign('instrument_id')->references('id')->on('instruments')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('bands', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('articles', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('users_teach_courses', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('users_teach_courses', function(Blueprint $table) {
			$table->foreign('course_id')->references('id')->on('courses')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('users_learn_courses', function(Blueprint $table) {
			$table->foreign('course_id')->references('id')->on('courses')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('users_learn_courses', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('band_members', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('band_members', function(Blueprint $table) {
			$table->foreign('band_id')->references('id')->on('bands')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('band_members', function(Blueprint $table) {
			$table->foreign('instrument_id')->references('id')->on('instruments')
						->onDelete('cascade')
						->onUpdate('no action');
		});
		Schema::table('band_events', function(Blueprint $table) {
			$table->foreign('band_id')->references('id')->on('bands')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('band_events', function(Blueprint $table) {
			$table->foreign('event_id')->references('id')->on('events')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('announcements', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('comments', function(Blueprint $table) {
			$table->foreign('announcement_id')->references('id')->on('announcements')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('comments', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('emails', function(Blueprint $table) {
			$table->foreign('receiver_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('emails', function(Blueprint $table) {
			$table->foreign('sender_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('images', function(Blueprint $table) {
			$table->foreign('article_id')->references('id')->on('articles')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('documents', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('documents', function(Blueprint $table) {
			$table->foreign('course_id')->references('id')->on('courses')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
	}

	public function down()
	{
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_department_id_foreign');
		});
		Schema::table('users', function(Blueprint $table) {
			$table->dropForeign('users_level_foreign');
		});
		Schema::table('courses', function(Blueprint $table) {
			$table->dropForeign('courses_instrument_id_foreign');
		});
		Schema::table('bands', function(Blueprint $table) {
			$table->dropForeign('bands_user_id_foreign');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->dropForeign('news_user_id_foreign');
		});
		Schema::table('articles', function(Blueprint $table) {
			$table->dropForeign('articles_user_id_foreign');
		});
		Schema::table('users_teach_courses', function(Blueprint $table) {
			$table->dropForeign('users_teach_courses_user_id_foreign');
		});
		Schema::table('users_teach_courses', function(Blueprint $table) {
			$table->dropForeign('users_teach_courses_course_id_foreign');
		});
		Schema::table('users_learn_courses', function(Blueprint $table) {
			$table->dropForeign('users_learn_courses_course_id_foreign');
		});
		Schema::table('users_learn_courses', function(Blueprint $table) {
			$table->dropForeign('users_learn_courses_user_id_foreign');
		});
		Schema::table('band_members', function(Blueprint $table) {
			$table->dropForeign('band_members_user_id_foreign');
		});
		Schema::table('band_members', function(Blueprint $table) {
			$table->dropForeign('band_members_band_id_foreign');
		});
		Schema::table('band_members', function(Blueprint $table) {
			$table->dropForeign('band_members_instrument_id_foreign');
		});
		Schema::table('band_events', function(Blueprint $table) {
			$table->dropForeign('band_events_band_id_foreign');
		});
		Schema::table('band_events', function(Blueprint $table) {
			$table->dropForeign('band_events_event_id_foreign');
		});
		Schema::table('announcements', function(Blueprint $table) {
			$table->dropForeign('announcements_user_id_foreign');
		});
		Schema::table('comments', function(Blueprint $table) {
			$table->dropForeign('comments_announcement_id_foreign');
		});
		Schema::table('comments', function(Blueprint $table) {
			$table->dropForeign('comments_user_id_foreign');
		});
		Schema::table('emails', function(Blueprint $table) {
			$table->dropForeign('emails_receiver_id_foreign');
		});
		Schema::table('emails', function(Blueprint $table) {
			$table->dropForeign('emails_sender_id_foreign');
		});
		Schema::table('images', function(Blueprint $table) {
			$table->dropForeign('images_article_id_foreign');
		});
		Schema::table('documents', function(Blueprint $table) {
			$table->dropForeign('documents_user_id_foreign');
		});
		Schema::table('documents', function(Blueprint $table) {
			$table->dropForeign('documents_course_id_foreign');
		});
	}
}