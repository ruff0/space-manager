<?php

namespace App\Files;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
	protected $table = 'files';

	protected $fillable = [
		'name',
		'path',
		'type',
		'extension',
		'pathname',
		'size'
	];
}
