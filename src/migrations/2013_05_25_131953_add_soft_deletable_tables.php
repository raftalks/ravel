<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSoftDeletableTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contents',function(Blueprint $table)
		{
			$table->softDeletes();
		});

		Schema::table('comments',function(Blueprint $table)
		{
			$table->softDeletes();
		});

		Schema::table('categories',function(Blueprint $table)
		{
			$table->softDeletes();
		});


		Schema::table('medias',function(Blueprint $table)
		{
			$table->softDeletes();
		});

		Schema::table('users',function(Blueprint $table)
		{
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
	}

}