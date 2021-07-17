<?php


namespace Latus\Permissions\Models\Traits;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Latus\Permissions\Models\Permission;

trait ResolvesPermissions
{

    protected array $resolvable_relationship_methods = [];

    public function resolvePermissions(): Collection
    {
        return Cache::remember($this->getTable() . '_' . $this->getKey(), 60, function () {
            $simple_permissions = [];

            if (!empty($this->resolvable_relationship_methods)) {
                foreach ($this->resolvable_relationship_methods as $relationship_method) {
                    $relationship = $this->$relationship_method()->get();
                    $simple_permissions += $relationship->resolvePermissions()->toArray();
                }
            }

            $simple_permissions += $this->permissions()
                ->where('name', 'not like', '%.*')
                ->whereNotIn('name', array_keys($simple_permissions))
                ->get()
                ->pluck('guard', 'name')
                ->all();

            $wildcard_permissions = $this->permissions()->where('name', 'like', '%.*')->get()->pluck('guard', 'name')->all();

            foreach ($wildcard_permissions as $wildcard_permission => $wildcard_permission_guard) {
                $simple_permissions += Permission::where('name', 'like', substr($wildcard_permission, 0, -1) . '%')
                    ->where('name', 'not like', '%.*')
                    ->whereNotIn('name', array_keys($simple_permissions))
                    ->get()
                    ->pluck('guard', 'name')
                    ->all();
            }

            return new Collection($simple_permissions);
        });
        
    }
}