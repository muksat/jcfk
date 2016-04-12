<?php

namespace Jcfk\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    protected $casts = [
        'is_active' => 'boolean',
        'role_id'   => 'integer'
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user';

    /**
     * @var string
     */
    protected $primaryKey = 'user_id';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['email'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function parent()
    {
        return $this->hasOne("Jcfk\Models\Parents");
    }

    /**
     * Is the current user an admin
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role_id === Role::ADMIN;
    }

    /**
     * @return bool
     */
    public function isParent()
    {
        return $this->role_id === Role::PARENT;
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->is_active;
    }

    /**
     * @param Request $request
     * @return User
     */
    public function registerOrUpdate(Request $request, $roleId)
    {
        $userId   = $request->get('user_id');

        if (!$userId) {
            return $this->register($request, $roleId);
        }

        $email    = $request->get('email');
        $password = $request->get('password');

        /** @var User $user */
        $user = $this->find($userId);

        $user->role_id = $roleId;
        $user->email   = $email;

        if ($password) {
            $user->password = Hash::make($password);
        }

        $user->save();

        return $user;
    }

    public function register(Request $request, $roleId)
    {
        $email    = $request->get('email');
        $password = $request->get('password');

        $user = new User();

        $user->role_id  = $roleId;
        $user->email    = $email;
        $user->password = Hash::make($password);

        $user->save();

        return $user;
    }

    /**
     * @return string
     */
    public function getAuthDefaultPath()
    {
        if ($this->isAdmin()) {
            return '/admin';
        }

        return '/parent';
    }
}
