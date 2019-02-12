<?php

namespace App\Models\User\RBAC;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * Class Permission
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Role[] $roles
 */
class Permission extends Model
{
    protected $fillable = ['name','description','permission_type','permission_id'];


    /**
     * @return Relation
     */
    public function roles() : Relation
    {
        return $this->belongsToMany(Role::class);
    }


    /**
     * @return Relation
     */
    public function permission() : Relation
    {
        return $this->morphTo();
    }

}
