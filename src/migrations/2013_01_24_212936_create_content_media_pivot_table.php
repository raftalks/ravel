<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentMediaPivotTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('content_media', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('content_id')->unsigned();
			$table->integer('media_id')->unsigned();
			$table->string('content_caption')->nullable();
			$table->integer('weight')->default(0);
			$table->timestamps();

			$table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
			$table->foreign('media_id')->references('id')->on('medias')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('content_media');
	}

}