<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class type_ticket extends Model
{
  protected $table = 'type_tickets';
  public function event_tikets()
  {

              return $this->hasMany(event_ticket::class);
  }

}
