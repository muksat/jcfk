<?php

namespace Jcfk\Validators;

class UserValidator extends AbstractValidator
{
    /**
     * Rules array
     *
     * @return array
     */
    protected function getRules()
    {
        return [
            'email'    => 'required|email|max:255',
            'password' => 'confirmed|min:6',
        ];
    }
}
