<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookableTypesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bookable_types', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('slug')->nullable();
			$table->text('description')->nullable();
			$table->boolean('active')->default(0);
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
		Schema::drop('bookable_types');
	}
}
