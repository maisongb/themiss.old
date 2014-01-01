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
				$table->dropColumn('username', 'provider');
			});
		}
	}

}