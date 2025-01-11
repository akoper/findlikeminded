<?php

namespace App\Models;

use App\Enum\UserRoleEnum;
use Database\Factories\GroupFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Group extends Model
{
    /** @use HasFactory<GroupFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location_id',
        'creator_id',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, GroupUser::class)
            ->withPivot('role')
            ->where('role','!=', UserRoleEnum::ADMIN);

    }

    public function admins(): BelongsToMany
    {
        return $this->belongsToMany(User::class, GroupUser::class)
            ->withPivot('role')
            ->where('role','=', UserRoleEnum::ADMIN);
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
