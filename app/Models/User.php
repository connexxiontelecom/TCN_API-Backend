<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use App\Models\Permissions;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var string[]
     */
    protected $hidden = [
        'password',
    ];

    public  function createUser(Array $parameters){
        $user = new User;
        $user->fullname = $parameters['fullname'];
        $user->email = $parameters['email'];
        $user->staff_id = $parameters['staff_id'];
        $user->status = 1;
        $user->usertype = 1;
        //all users initially have a default password that must be changed
        $plainPassword = "password1234";//$parameters['password'];
        $user->password = '$2y$10$NzDrWAgnHPNNx6JC4mE3MOin55A/QR4WJvzT6tFGbeU45dOl/aTwm';//app('hash')->make($plainPassword);
        $user->uuid = uniqid();
        $user->save();
        return $user;
    }

    public function isExist($email, $staffId){
        $exists = User::where("email", $email)->orWhere('staff_id', $staffId)->first();
        if ($exists != null) {
            return true;
        }
        else{
            return false;
        }
    }

    public function allUsers(){
        $users = User::all();
        $permissions = new Permissions();
        foreach ($users as $user){
            $user->permissions = $permissions->getPermissions($user->id);
        }
        return $users;
    }
}
