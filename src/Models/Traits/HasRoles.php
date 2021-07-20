<?php


namespace Latus\Permissions\Models\Traits;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Latus\Permissions\Models\Role;

trait HasRoles
{
    use HasPermissions;

    public function primaryRole(): Role
    {
        return $this->roles()->orderBy('level', 'desc')->first();
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}