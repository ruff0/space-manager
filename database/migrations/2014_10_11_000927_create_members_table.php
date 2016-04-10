<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('members', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('identity');
			$table->string('address_line1');
			$table->string('address_line2');
			$table->string('zip');
			$table->string('city');
			$table->string('state');
			$table->string('phone');
			$table->string('mobile');
			$table->string('company_name');
			$table->string('company_identity');
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
		Schema::drop('members');
	}
}
