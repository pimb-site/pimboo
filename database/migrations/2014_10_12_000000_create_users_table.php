<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->string('email')->unique();
			$table->string('password', 60);
			$table->string('photo');
			$table->string('cover_photo');
			$table->longText('public_info');
			$table->string('website_link');
			$table->boolean('show_website_link')->default(0); 
			$table->string('fb_link');
			$table->boolean('show_fb_link')->default(0); 
			$table->string('twitter_link');
			$table->boolean('show_twitter_link')->default(0); 
			$table->string('google_pluse_link');
			$table->boolean('show_google_pluse_link')->default(0); 
			$table->boolean('weekly_digest')->default(0); 
			$table->boolean('new_subs_update')->default(0); 
			$table->boolean('activated')->default(0); 
			$table->rememberToken();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
