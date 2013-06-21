<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('medias', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('media_type'); // IMAGE FILE | VIDEO FILE | YOUTUBE
			$table->string('path');
			$table->string('caption')->default(null);
			$table->boolean('publish')->default(false);
			$table->boolean('approved')->default(false);
			$table->text('filedata')->nullable();
			$table->string('keywords')->default(null);
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
		Schema::drop('medias');
	}

}