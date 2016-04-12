<?php

namespace Jcfk\Auth;

use Illuminate\Auth\EloquentUserProvider;

class ActiveUserProvider extends EloquentUserProvider
{
    /**
     * Retrieve a user by the given credentials.
     *
     * @param  array $credentials
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByCredentials(array $credentials)
    {
        /** @var \Jcfk\Models\User $user */
        $user = parent::retrieveByCredentials($credentials);

        if ($user && $user->isActive()) {
            return $user;
        }

        return null;
    }
}
