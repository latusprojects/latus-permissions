<?php


namespace Latus\Permissions\Models\Traits;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Latus\Permissions\Models\Role;

trait HasRoles
{
    use HasPermissions;

    /**
     * Gets the primary role of this model
     *
     * @return Role
     */
    public function primaryRole(): Role
    {
        return $this->roles()->orderBy('level', 'desc')->first();
    }

    /**
     * Gets all roles of this model
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}