<?php

namespace App\Models;

use Database\Factories\EventUserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    /** @use HasFactory<EventUserFactory> */
    use HasFactory;

    protected $table = 'event_user';

    protected $fillable = [
        'group_id',
        'user_id',
    ];
}
