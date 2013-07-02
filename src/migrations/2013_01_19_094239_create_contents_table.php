<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contents', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('lang',3);
			$table->integer('author_id')->unsigned();
			$table->string('author_name')->nullable(); //name to overide actual username
			$table->string('content_type'); //post, page, attachement
			$table->string('content_mime_type')->nullable(); //for attachments only
			$table->string('title');
			$table->string('slug');
			$table->text('content');
			$table->text('excerpt');
			$table->string('status')->default('draft'); //draft, submitted, published,
			$table->boolean('allow_comments')->default(true);
			$table->integer('comment_end')->nullable(); //ending from number of days from published date

			$table->boolean('content_locked')->default(false);
			$table->string('content_password',64)->nullable();
			$table->integer('parent_id')->default(0)->unsigned();
			$table->integer('comment_count')->default(0);
			$table->datetime('publish_date');
			$table->timestamps();

			$table->unique(array('slug','content_type','lang','publish_date'),'contents_unique');

			$table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');


		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contents');
	}

}