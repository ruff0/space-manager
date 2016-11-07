<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;

class EloquentEvent extends Model {

	protected $table = 'events';

	protected $fillable = ["*"];

	protected $primaryKey = 'id';

	protected $keyType = 'string';

	public $timestamps = false;
}