<?php

namespace Latus\Permissions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Latus\Permissions\Models\Traits\Permissible;

class Role extends Model
{
    use HasFactory, Permissible;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

}
