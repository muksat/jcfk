<?php

namespace Jcfk\Validators;

class AuthValidator extends AbstractValidator
{
    /**
     * Rules array
     *
     * @return array
     */
    protected function getRules()
    {
        return [
            'email'    => 'required',
            'password' => 'required',
        ];
    }
}
