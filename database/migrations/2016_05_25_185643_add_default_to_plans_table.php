<?php

use Illuminate\Database\Schema\Blueprint;

class AddDefaultToPlansTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('plans', function (Blueprint $table) {
			$table->boolean('default', $table)->default(false);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('plans', function (Blueprint $table) {
			$table->dropColumn('default');
		});
	}
}
