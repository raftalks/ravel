<?php

use Illuminate\Database\Migrations\Migration;

class AddSoftDeletableTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('contents',function($table)
		{
			$table->timestamp('deleted_at');
		});

		Schema::table('comments',function($table)
		{
			$table->timestamp('deleted_at');
		});

		Schema::table('categories',function($table)
		{
			$table->timestamp('deleted_at');
		});


		Schema::table('medias',function($table)
		{
			$table->timestamp('deleted_at');
		});

		Schema::table('users',function($table)
		{
			$table->timestamp('deleted_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('contents',function($table)
		{
			$table->dropColumn('deleted_at');
		});

		Schema::table('comments',function($table)
		{
			$table->dropColumn('deleted_at');
		});

		Schema::table('categories',function($table)
		{
			$table->dropColumn('deleted_at');
		});

		Schema::table('medias',function($table)
		{
			$table->dropColumn('deleted_at');
		});

		Schema::table('users',function($table)
		{
			$table->dropColumn('deleted_at');
		});
	}

}