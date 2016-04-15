<?php namespace App\Resources\Models;


class Price extends AbstractResource
{
	/**
	 * The corresponding table.
	 *
	 * @var string
	 */
	protected $table = 'prices';

	/**
	 * @var array
	 */
	protected $fillable = [
		'name',
		'slug',
		'description',
		'active'
	];


	public $type = 'price';

	public $category = 'price';
}