<?php

namespace Jcfk\Validators;

class TeacherValidator extends AbstractValidator
{
    /**
     * Rules array
     *
     * @return array
     */
    protected function getRules()
    {
        return [
            'name' => 'required',
            'room' => 'required',
            'school_id' => 'required|exists:school,school_id'
        ];
    }

    /**
     * @return array
     */
    protected function getCustomMessages()
    {
        return [
            'school_id.required' => 'The school field is required.',
            'school_id.exists'   => 'School does not exist.'
        ];
    }
}
