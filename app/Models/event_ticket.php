<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event_ticket extends Model
{
    use HasFactory;
    protected $table = 'event_tickets';
    public function type_ticket()
    {
        return $this->belongsTo(type_ticket::class);

    }
}
