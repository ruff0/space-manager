<?php

use Illuminate\Database\Schema\Blueprint;

class AddPlanTypeIdToPlansTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('plans', function (Blueprint $table) {
			$this->relationColumn('plan_type', $table);
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
			$table->dropColumn('plan_type');
		});
	}
}
