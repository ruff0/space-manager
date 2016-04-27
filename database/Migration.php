<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration as LaravelMigration;

class Migration extends LaravelMigration
{
	public function relationColumn($column, $table, $name = null)
	{
		$table->integer("{$column}_id")->unsigned()->nullable();

		$table->foreign("{$column}_id", $name)
		      ->references('id')
		      ->on("{$column}s")
		      ->onDelete('cascade');
	}
}
