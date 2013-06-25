<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMediacollectionFkToMediasLink extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('medias', function(Blueprint $table)
		{
			$table->foreign('mcollection_id','mcollection_id_fk')->references('id')->on('mcollections')->onUpdate('cascade')->onDelete('cascade');
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
			$table->dropForeign('mcollection_id_fk');
		});
	}

}