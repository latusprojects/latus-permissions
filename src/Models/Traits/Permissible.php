<?php

namespace Latus\Permissions\Models\Traits;

use Latus\Permissions\Models\Permission;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait Permissible
{
    use ResolvesPermissions;

    public function hasOnePermission(array $names): bool
    {
        foreach ($names as $name) {
            if ($this->hasPermission($name)) {
                return true;
            }
        }
        return false;
    }

    public function hasPermission(string $name): bool
    {
        return $this->resolvePermissions()->offsetExists($name);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }

}
