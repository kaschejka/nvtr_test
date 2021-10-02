<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class event extends Model
{
  use HasFactory;
    protected $table = 'events';
    protected $guarded = [];
    public function event_ticket_price()
    {
        return $this->hasMany(event_ticket::class);
    }
}
