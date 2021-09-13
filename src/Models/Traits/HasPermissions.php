<?php

namespace Latus\Permissions\Models\Traits;

use Latus\Permissions\Models\Contracts\Permissible;
use Latus\Permissions\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasPermissions
{
    use ResolvesPermissions;

    /**
     * @see Permissible::hasOnePermission()
     */
    public function hasOnePermission(array $names): bool
    {
        foreach ($names as $name) {
            if ($this->hasPermission($name)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @see Permissible::hasPermission()
     */
    public function hasPermission(string $name): bool
    {
        return $this->resolvePermissions()->offsetExists($name);
    }

    /**
     * @see Permissible::permissions()
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

}
