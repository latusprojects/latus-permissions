<?php


namespace Latus\Permissions\Models\Contracts;


use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

interface Permissible
{
    public function hasOnePermission(array $names): bool;

    public function hasPermission(string $name): bool;

    public function permissions(): BelongsToMany;

    public function resolvePermissions(): Collection;
}