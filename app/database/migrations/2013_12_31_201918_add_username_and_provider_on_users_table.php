<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsernameAndProviderOnUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(){
		if(Schema::hasTable('users')){
			Schema::table('users', function(Blueprint $table){
				$table->string('username')->unique();
				$table->string('provider');
				$table->text('facebook_token')->nullable();
				$table->text('instagram_token')->nullable();

				DB::statement("ALTER TABLE users DROP email");
				$table->string('email')->nullable();
			});
		}
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(){
		if(Schema::hasTable('users')){
			Schema::table('users', function(Blueprint $table){
				$table->dropUnique('users_username_unique');
				$table->dropColumn('username', 'facebook_token', 'instagram_token', 'provider');
			});
		}
	}

}