<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageablesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('imageables', function (Blueprint $table) {
			$table->integer('image_id');
			$table->integer('imageable_id');
			$table->string('imageable_type');
			$table->index(["image_id", "imageable_id", "imageable_type"], "image_index");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('imageables');
	}
}
