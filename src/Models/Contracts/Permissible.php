<?php


namespace Latus\Permissions\Models\Contracts;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

interface Permissible
{
    /**
     * Checks if this model has at least one of the specified permissions
     *
     * @param array $names
     * @return bool
     */
    public function hasOnePermission(array $names): bool;

    /**
     * Checks if this model has a specific permission
     *
     * @param string $name
     * @return bool
     */
    public function hasPermission(string $name): bool;

    /**
     * Gets permissions of this model, excluding those of parent and child models
     *
     * @return BelongsToMany
     */
    public function permissions(): BelongsToMany;

    /**
     * Gets all permissions of this model, including those of parent and child models
     *
     * @return Collection
     */
    public function resolvePermissions(): Collection;
}