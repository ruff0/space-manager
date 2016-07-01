<?php

use Illuminate\Database\Schema\Blueprint;

class CreatePermisionRolePivotTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('permission_role', function (Blueprint $table) {
			$this->relationColumn('permission', $table, null, false);
			$this->relationColumn('role', $table, null, false);
			$table->primary(['permission_id', 'role_id']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('permission_role');
	}
}
