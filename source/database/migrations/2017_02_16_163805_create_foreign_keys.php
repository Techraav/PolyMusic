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
			$table->foreign('level_id')->references('id')->on('levels')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('courses', function(Blueprint $table) {
			$table->foreign('instrument_id')->references('id')->on('instruments')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('courses', function(Blueprint $table) {
			$table->foreign('article_id')->references('id')->on('articles')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('courses', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('events', function(Blueprint $table) {
			$table->foreign('article_id')->references('id')->on('articles')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('bands', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('bands', function(Blueprint $table) {
			$table->foreign('article_id')->references('id')->on('articles')
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
		Schema::table('articles', function(Blueprint $table) {
			$table->foreign('category_id')->references('id')->on('categories')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('course_user', function(Blueprint $table) {
			$table->foreign('course_id')->references('id')->on('courses')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('course_user', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('band_user', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('band_user', function(Blueprint $table) {
			$table->foreign('band_id')->references('id')->on('bands')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('band_user', function(Blueprint $table) {
			$table->foreign('instrument_id')->references('id')->on('instruments')
						->onDelete('cascade')
						->onUpdate('no action');
		});
		Schema::table('band_event', function(Blueprint $table) {
			$table->foreign('band_id')->references('id')->on('bands')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('band_event', function(Blueprint $table) {
			$table->foreign('event_id')->references('id')->on('events')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('announcements', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('announcements', function(Blueprint $table) {
			$table->foreign('category_id')->references('id')->on('categories')
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
		Schema::table('modifications', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('course_modifications', function(Blueprint $table) {
			$table->foreign('author_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('course_modifications', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('course_modifications', function(Blueprint $table) {
			$table->foreign('course_id')->references('id')->on('courses')
						->onDelete('cascade')
						->onUpdate('cascade');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->foreign('user_id')->references('id')->on('users')
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
			$table->dropForeign('users_level_id_foreign');
		});
		Schema::table('courses', function(Blueprint $table) {
			$table->dropForeign('courses_instrument_id_foreign');
		});
		Schema::table('courses', function(Blueprint $table) {
			$table->dropForeign('courses_article_id_foreign');
		});
		Schema::table('courses', function(Blueprint $table) {
			$table->dropForeign('courses_user_id_foreign');
		});
		Schema::table('events', function(Blueprint $table) {
			$table->dropForeign('events_article_id_foreign');
		});
		Schema::table('bands', function(Blueprint $table) {
			$table->dropForeign('bands_user_id_foreign');
		});
		Schema::table('bands', function(Blueprint $table) {
			$table->dropForeign('bands_article_id_foreign');
		});
		Schema::table('news', function(Blueprint $table) {
			$table->dropForeign('news_user_id_foreign');
		});
		Schema::table('articles', function(Blueprint $table) {
			$table->dropForeign('articles_user_id_foreign');
		});
		Schema::table('articles', function(Blueprint $table) {
			$table->dropForeign('articles_category_id_foreign');
		});
		Schema::table('course_user', function(Blueprint $table) {
			$table->dropForeign('course_user_course_id_foreign');
		});
		Schema::table('course_user', function(Blueprint $table) {
			$table->dropForeign('course_user_user_id_foreign');
		});
		Schema::table('band_user', function(Blueprint $table) {
			$table->dropForeign('band_user_user_id_foreign');
		});
		Schema::table('band_user', function(Blueprint $table) {
			$table->dropForeign('band_user_band_id_foreign');
		});
		Schema::table('band_user', function(Blueprint $table) {
			$table->dropForeign('band_user_instrument_id_foreign');
		});
		Schema::table('band_event', function(Blueprint $table) {
			$table->dropForeign('band_event_band_id_foreign');
		});
		Schema::table('band_event', function(Blueprint $table) {
			$table->dropForeign('band_event_event_id_foreign');
		});
		Schema::table('announcements', function(Blueprint $table) {
			$table->dropForeign('announcements_user_id_foreign');
		});
		Schema::table('announcements', function(Blueprint $table) {
			$table->dropForeign('announcements_category_id_foreign');
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
		Schema::table('images', function(Blueprint $table) {
			$table->dropForeign('images_article_id_foreign');
		});
		Schema::table('documents', function(Blueprint $table) {
			$table->dropForeign('documents_user_id_foreign');
		});
		Schema::table('documents', function(Blueprint $table) {
			$table->dropForeign('documents_course_id_foreign');
		});
		Schema::table('modifications', function(Blueprint $table) {
			$table->dropForeign('modifications_user_id_foreign');
		});
		Schema::table('course_modifications', function(Blueprint $table) {
			$table->dropForeign('course_modifications_author_id_foreign');
		});
		Schema::table('course_modifications', function(Blueprint $table) {
			$table->dropForeign('course_modifications_user_id_foreign');
		});
		Schema::table('course_modifications', function(Blueprint $table) {
			$table->dropForeign('course_modifications_course_id_foreign');
		});
		Schema::table('notifications', function(Blueprint $table) {
			$table->dropForeign('notifications_user_id_foreign');
		});
	}
}