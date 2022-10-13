<?php

namespace Latus\Permissions\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Latus\Permissions\Helpers\Classes;


class Role extends ModelWithPermissible
{
    use HasFactory;

    protected $fillable = [
        'name', 'level'
    ];

    protected array $resolvable_relationship_methods = [
        'children'
    ];

    /**
     * Gets all users with this role
     *
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(Classes::user())->withTimestamps();
    }

    /**
     * Gets all parent-roles
     *
     * @return BelongsToMany
     */
    public function parents(): BelongsToMany
    {
        return $this->belongsToMany(Classes::role(), 'role_child_role', 'child_role_id', 'role_id')->withTimestamps();
    }

    /**
     * Gets all child-roles
     *
     * @return BelongsToMany
     */
    public function children(): BelongsToMany
    {
        return $this->belongsToMany(Classes::role(), 'role_child_role', 'role_id', 'child_role_id')->withTimestamps();
    }

}
