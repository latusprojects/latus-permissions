<?php


namespace Latus\Permissions\Models\Traits;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Latus\Permissions\Helpers\Classes;
use Latus\Permissions\Models\Contracts\Permissible;

trait ResolvesPermissions
{

    protected array $resolvable_relationship_methods = [];

    /**
     * @see Permissible::resolvePermissions()
     */
    public function resolvePermissions(array $resolvedRelationships = []): Collection
    {
        return Cache::remember($this->getTable() . '_' . $this->getKey(), 60, function () use ($resolvedRelationships) {
            $simple_permissions = [];

            if (!empty($this->resolvable_relationship_methods)) {
                foreach ($this->resolvable_relationship_methods as $relationship_method) {
                    /**
                     * @var Collection $relationships
                     */
                    $relationships = $this->$relationship_method()->get();

                    foreach ($relationships as $relationship) {
                        $relationshipClass = get_class($relationship);
                        $relationshipId = $relationship->id;
                        /**
                         * Prevents infinite recursion
                         **/
                        if (isset($resolvedRelationships[$relationshipClass])
                            && in_array($relationshipId, $resolvedRelationships[$relationshipClass])) {
                            continue;
                        }

                        if (!isset($resolvedRelationships[$relationshipClass])) {
                            $resolvedRelationships[$relationshipClass] = [];
                        }
                        $resolvedRelationships[$relationshipClass][] = $relationshipId;

                        $simple_permissions += $relationship->resolvePermissions($resolvedRelationships)->toArray();
                    }
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
                $simple_permissions += Classes::permission()::where('name', 'like', substr($wildcard_permission, 0, -1) . '%')
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