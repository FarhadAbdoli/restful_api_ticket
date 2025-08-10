<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketItems extends Model
{
    use HasFactory;

    public $table = "ticket_items";
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = true;
}
