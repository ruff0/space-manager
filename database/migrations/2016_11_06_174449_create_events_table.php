<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('events', function (Blueprint $table) {
			$table->string("id")->primary();
			$table->string("title")->default("");
			$table->longText("description")->default("");
			$table->string("image")->default("");
			$table->date("date");
			$table->time("from");
			$table->time("to");
			$this->relationColumn('booking', $table, null, false);
			$this->relationColumn('resource', $table, null, false);
			$this->relationColumn('member', $table, null, false);
			$table->string("distribution")->nullable();
			$table->integer("persons");

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('events');
	}
}
