<?php

use Illuminate\Database\Schema\Blueprint;

class CreateRoleUserPivotTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('role_user', function (Blueprint $table) {
			$this->relationColumn('role', $table, null, false);
			$this->relationColumn('user', $table, null, false);
			$table->primary(['role_id', 'user_id']);
		});

	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('role_user');
	}
}
