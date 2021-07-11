<?php

namespace Latus\Permissions\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;

class Role extends Model
{
    use HasFactory;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function effectivePermissions(): Collection
    {
        return $this->permissions()->get();
    }

    public function resolvePermissions(): \Illuminate\Support\Collection
    {
        $simple_permissions = $this->permissions()->where('name', 'not like', '%.*')->get()->pluck('guard', 'name')->all();

        $wildcard_permissions = $this->permissions()->where('name', 'like', '%.*')->get()->pluck('guard', 'name')->all();

        foreach ($wildcard_permissions as $wildcard_permission => $wildcard_permission_guard) {
            $simple_permissions += Permission::where('name', 'like', substr($wildcard_permission, 0, -1) . '%')
                ->where('name', 'not like', '%.*')
                ->whereNotIn('name', array_keys($simple_permissions))
                ->get()
                ->pluck('guard', 'name')
                ->all();
        }

        return new \Illuminate\Support\Collection($simple_permissions);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }
}
