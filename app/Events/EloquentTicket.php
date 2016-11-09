<?php

namespace App\Events;

use Illuminate\Database\Eloquent\Model;

class EloquentTicket extends Model
{

    protected $table = 'tickets';

    protected $fillable = ["*"];

    public $timestamps = false;

    public function events()
    {
        return $this->belongsTo(EloquentEvent::class);
    }
}