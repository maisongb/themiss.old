<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSurveysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('surveys', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('title')->nullable();
			$table->timestamp('expires_at');
			$table->enum('active', array(1, 0))->default(1);
			$table->timestamps();
		});

		Schema::create('survey_questions', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('survey_id')->unsigned();
			$table->foreign('survey_id')->references('id')->on('surveys');

			$table->text('question');
			$table->enum('active', array(1, 0));
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
		Schema::drop('surveys');
	}

}
