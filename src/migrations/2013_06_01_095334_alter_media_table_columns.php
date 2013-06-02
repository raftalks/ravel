<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterMediaTableColumns extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		DB::update(DB::raw('ALTER TABLE  `medias` CHANGE  `caption`  `caption` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL'));
		DB::update(DB::raw('ALTER TABLE  `medias` CHANGE  `keywords`  `keywords` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL'));
		
		Schema::table('medias', function(Blueprint $table)
		{
			$table->string('file_name')->after('path');
			$table->integer('user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('medias', function(Blueprint $table)
		{
			//
		});
	}

}