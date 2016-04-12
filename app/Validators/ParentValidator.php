<?php

namespace Jcfk\Validators;

class ParentValidator extends UserValidator
{
    /**
     * Rules array
     *
     * @return array
     */
    protected function getRules()
    {
        $userRules = parent::getRules();

        return array_merge(
            $userRules,
            [
                'name' => 'required',
            ]
        );
    }
}
