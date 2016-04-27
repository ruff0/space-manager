<?php

use Illuminate\Database\Schema\Blueprint;

class CreateInvoicesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('invoices', function (Blueprint $table) {
			$table->increments('id');
			$table->boolean('paid');
			$this->relationColumn('member', $table);
			$table->integer('subtotal');
			$table->integer('total');
			$table->integer('tax');
			$table->integer('vat');
			$table->string('name')->nullable();
			$table->string('lastname')->nullable();
			$table->string('email');
			$table->string('identity')->nullable();
			$table->string('address_line1');
			$table->string('address_line2');
			$table->string('zip');
			$table->string('city');
			$table->string('state');
			$table->string('phone');
			$table->string('mobile');
			$table->boolean('is_company');
			$table->string('company_name')->nullable();
			$table->string('company_identity')->nullable();
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
		Schema::drop('invoices');
	}
}
