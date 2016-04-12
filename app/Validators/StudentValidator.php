<?php

namespace Jcfk\Validators;

class StudentValidator extends AbstractValidator
{
    /**
     * Rules array
     *
     * @return array
     */
    protected function getRules()
    {
        return [
            'name'       => 'required',
            'teacher_id' => 'required|exists:teacher,teacher_id'
        ];
    }

    /**
     * @return array
     */
    protected function getCustomMessages()
    {
        return [
            'teacher_id.required' => 'The teacher field is required.',
            'teacher_id.exists'   => 'Teacher does not exist.'
        ];
    }
}
