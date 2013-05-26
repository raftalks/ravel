<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('comments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('author_id')->unsigned();
			$table->string('author_name')->nullable();
			$table->string('author_email')->nullable();
			$table->string('ipaddress',100);
			$table->boolean('private')->default(false);
			$table->integer('parent_id')->default(0)->unsigned();
			$table->integer('content_id')->unsigned();
			$table->text('content');
			$table->boolean('approved')->default(false);
			$table->integer('likes')->default(0);
			$table->integer('dislikes')->default(0);
			$table->timestamps();

			$table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');
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
		Schema::drop('comments');
	}

}