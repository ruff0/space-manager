<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClassRoomsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('class_rooms', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('slug')->nullable();
			$table->text('description')->nullable();
			$table->integer('floor');
			$table->integer('max_occupants');
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
		Schema::drop('class_rooms');
	}
}
