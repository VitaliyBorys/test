<?php
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 5/14/18
 * Time: 12:18 PM
 */

namespace App\Repositories;


use App\User;

class Users
{

    public function update(User $user, $data)
    {
        $user->update($data);

        //Update password
        if(!empty($data['password']) && !empty($data['new_password'])){
            $user->password = bcrypt($data['new_password']);
            $user->save();
        }

        if(isset($data['role']) && !empty($data['role'])){
            $user->roles()->sync([$data['role']['id']]);
        }
        return $this;
    }

}