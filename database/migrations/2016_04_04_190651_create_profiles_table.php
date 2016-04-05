<?php

use Illuminate\Database\Schema\Blueprint;

class CreateProfilesTable extends \Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profiles', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('lastname');
			$table->string('identity');
			$table->string('address_line1');
			$table->string('address_line2');
			$table->string('zip');
			$table->string('city');
			$table->string('state');
			$table->string('phone');
			$table->string('mobile');
			$this->relationColumn('user', $table);
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
		Schema::drop('profiles');
	}
}
