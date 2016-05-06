<?php

use Illuminate\Database\Schema\Blueprint;

class CreateSubscriptionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscriptions', function (Blueprint $table) {
			$table->increments('id');
			$this->relationColumn('member', $table);
			$this->relationColumn('plan', $table);
			$this->relationColumn('resource', $table);
			$table->timestamp('date_from')->default("0000-00-00 00:00:00");
			$table->timestamp('date_to')->default("0000-00-00 00:00:00");
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
		Schema::drop('subscriptions');
	}
}
