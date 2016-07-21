<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResourceablesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('resourceables', function (Blueprint $table) {
			$table->integer('resource_id');
			$table->integer('resourceable_id');
			$table->string('resourceable_type');
			$table->index(["resource_id", "resourceable_id", "resourceable_type"], "resource_index");
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('resourceables');
	}
}
