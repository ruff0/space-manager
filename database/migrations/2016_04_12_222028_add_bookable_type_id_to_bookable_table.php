<?php

use Illuminate\Database\Schema\Blueprint;

class AddBookableTypeIdToBookableTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('bookables', function (Blueprint $table) {
			$this->relationColumn('bookable_type', $table);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('bookables', function (Blueprint $table) {
			$table->dropColumn('bookable_type');
		});
	}
}
