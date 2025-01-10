<?php

namespace App\Models;

use Database\Factories\GroupFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use phpDocumentor\Reflection\Types\Integer;


class Group extends Model
{
    /** @use HasFactory<GroupFactory> */
    use HasFactory;

    public Integer $creator_id;
    protected $fillable = [
        'name',
        'description',
        'location_id',
        'creator_id',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function events(): HasMany
    {
        return $this->hasMany(Event::class);
    }


    public function location(): BelongsTo
    {
        return $this->BelongsTo(Location::class);
    }
}
