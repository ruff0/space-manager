<?php

use Illuminate\Database\Schema\Blueprint;

class CreateBookingsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bookings', function (Blueprint $table) {
			$table->increments('id');
			$this->relationColumn('member', $table);
			$this->relationColumn('bookable', $table);
			$this->relationColumn('resource', $table);
			$table->timestamp('time_from')->default("0000-00-00 00:00:00");
			$table->timestamp('time_to')->default("0000-00-00 00:00:00");
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
		Schema::drop('bookings');
	}
}
