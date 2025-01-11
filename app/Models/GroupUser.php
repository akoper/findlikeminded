<?php

namespace App\Models;

use Database\Factories\GroupFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class GroupUser extends Pivot
{
    /** @use HasFactory<GroupFactory> */
    use HasFactory;

    protected $table = 'group_user';

    protected $fillable = [
        'group_id',
        'user_id',
        'role',
    ];
}
