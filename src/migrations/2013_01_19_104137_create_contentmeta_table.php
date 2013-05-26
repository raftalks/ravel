<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentmetaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contentmetas', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('content_id')->unsigned();
			$table->string('metakey');
			$table->text('metavalue');

			$table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contentmetas');
	}

}