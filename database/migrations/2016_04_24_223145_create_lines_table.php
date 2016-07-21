<?php

use Illuminate\Database\Schema\Blueprint;

class CreateLinesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lines', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('description');
			$table->integer('amount');
			$table->integer('price');
			$table->integer('subtotal');
			$this->relationColumn('invoice', $table);
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
		Schema::drop('lines');
	}
}
