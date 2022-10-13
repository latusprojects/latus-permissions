<?php

namespace Latus\Permissions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Latus\Permissions\Helpers\Classes;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'guard'];

    /**
     * Gets all roles that were granted this permission
     *
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Classes::role())->withTimestamps();
    }

    /**
     * Gets all users that were granted this permission
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Classes::user())->withTimestamps();
    }
}
