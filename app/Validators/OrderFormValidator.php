<?php

namespace Jcfk\Validators;

class OrderFormValidator extends AbstractValidator
{
    /**
     * Rules array
     *
     * @return array
     */
    protected function getRules()
    {
        return [
              'start_date' => 'required|date_format:m/d/Y',
              'end_date' => 'required|date_format:m/d/Y|after:start_date',
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
