<?php

namespace Latus\Permissions\Models\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Latus\Permissions\Helpers\Classes;
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
        $primaryRole = $this->roles()->orderBy('level', 'desc')->first();

        if (!$primaryRole) {
            return Classes::role()::where('name', config('latus-permissions.default_role'))->first();
        }

        return $primaryRole;
    }

    /**
     * Gets all roles of this model
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Classes::role())->withTimestamps();
    }
}