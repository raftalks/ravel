<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username',100)->unique();
		    $table->string('email')->unique();
		    $table->string('password');
		    $table->string('first_name',100);
		    $table->string('last_name',100);
		    $table->string('api_token',100);
		    $table->integer('usergroup_id')->unsigned();
		    $table->boolean('activated')->default(false);
		    $table->timestamps();

		    $table->foreign('usergroup_id')->references('id')->on('usergroups')->onDelete('restrict')->onUpdate('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		
		Schema::drop('users');
	}

}