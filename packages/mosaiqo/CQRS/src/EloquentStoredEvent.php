<?php

namespace Mosaiqo\Cqrs;

use Illuminate\Database\Eloquent\Model;
use Mosaiqo\Cqrs\Contracts\DomainEvent;

class EloquentStoredEvent extends Model {

	protected $table = 'event_store';

	protected $fillable = ['id', 'type', 'occurredAt', 'payload'];

	protected $dates = ["occurredAt"];

	protected $keyType = "string";

	public $timestamps = false;
}