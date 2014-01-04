<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVotesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('votes', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('voter_id')->unsigned();
			$table->foreign('voter_id')->references('id')->on('users');

			$table->integer('picture_id')->unsigned();
			$table->foreign('picture_id')->references('id')->on('pictures');

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
		Schema::table('votes', function($table)
		{
			$table->dropForeign('votes_voter_id_foreign');	
			$table->dropForeign('votes_picture_id_foreign');	
		});

		Schema::drop('votes');
	}

}
