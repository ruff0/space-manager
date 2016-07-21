<?php

use Illuminate\Database\Schema\Blueprint;

class CreatePassesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('passes', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('hours');
			$table->date('date_to');
			$this->relationColumn('member', $table);
			$this->relationColumn('bookable', $table);
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
		Schema::drop('passes');
	}
}
