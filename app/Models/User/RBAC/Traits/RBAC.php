<?php

namespace App\Models\User\RBAC\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\User\RBAC\Role;

trait RBAC
{

    /**
     * @return Relation
     */
    public function roles(): Relation
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * @param string|array $name
     * @param bool $required
     * @return bool
     */
    public function hasRole(string $name, bool $required = false): bool
    {
        if (is_array($name)) {
            foreach ($name as $roleName) {

                $hasRole = $this->hasRole($roleName);
                if ($hasRole && !$required)
                    return true;
                elseif (!$hasRole && $required)
                    return false;
            }

            return $required;

        } else {
            foreach ($this->roles as $role) {
                if (str_is($role->name, $name))
                    return true;
            }
        }
        return false;
    }


    /**
     * @param string $name
     * @param bool $required
     * @return bool
     */
    public function hasPermission(string $name, bool $required = false): bool
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($name, $required)) {
                return true;
            }
        }
        return false;
    }
}