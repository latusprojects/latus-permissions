<?php

namespace Latus\Permissions\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\User;
use Latus\Permissions\Models\Traits\ResolvesPermissions;

class Role extends Model
{
    use HasFactory, ResolvesPermissions;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function effectivePermissions(): Collection
    {
        return $this->permissions()->get();
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class)->withTimestamps();
    }
}
