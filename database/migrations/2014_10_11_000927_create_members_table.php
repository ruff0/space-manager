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
			$table->string('name')->nullable();
			$table->string('lastname')->nullable();
			$table->string('email');
			$table->string('identity')->nullable();
			$table->string('address_line1');
			$table->string('address_line2');
			$table->string('zip');
			$table->string('city');
			$table->string('state');
			$table->string('phone');
			$table->string('mobile');
			$table->boolean('is_company');
			$table->string('company_name')->nullable();
			$table->string('company_identity')->nullable();
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
