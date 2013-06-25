<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMediacollectionFkToMedias extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		//not required anymore
		Schema::dropIfExists('mcollection_media');


		Schema::table('medias', function(Blueprint $table)
		{
			$table->integer('mcollection_id')->after('id')->unsigned();
			$table->string('url')->after('path');
			
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