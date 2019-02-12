<?php

namespace App\Models\User\RBAC;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Class Role
 * @property int $id
 * @property string $name
 * @property string $description
 * @property User[] $users
 * @property Permission[] $permissions
 */
class Role extends Model
{
    protected $fillable = ['name','description'];


    /**
     * @return Relation
     */
    public function users(): Relation
    {
        return $this->belongsToMany(User::class, 'role_user');
    }


    /**
     * @return Relation
     */
    public function permissions(): Relation
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    /**
     * @param string|array $name
     * @param bool $required
     * @return boolean
     */
    public function hasPermission(string $name, bool $required = FALSE): bool
    {
        if (is_array($name)) {
            foreach ($name as $permission) {
                $hasPermission = $this->hasPermission($permission);
                if ($hasPermission && !$required)
                    return TRUE;
                elseif (!$hasPermission && $required)
                    return FALSE;
            }
            return $required;

        } else {
            foreach ($this->permissions as $permission) {
                if (str_is($permission->name, $name))
                    return TRUE;
            }
        }
        return false;
    }


    /**
     * @return Role
     */
    public static function getDafaultRole(): self
    {
        return self::where('name', 'user')->first();
    }
}