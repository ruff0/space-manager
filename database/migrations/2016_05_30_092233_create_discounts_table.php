<?php

use Illuminate\Database\Schema\Blueprint;

class CreateDiscountsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('discounts', function (Blueprint $table) {
			$table->increments('id');
			$table->integer('percentage');
			$this->relationColumn('member', $table);
			$table->string('type');
			$table->timestamp('date_from');
			$table->timestamp('date_to');
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
		Schema::drop('discounts');
	}
}
