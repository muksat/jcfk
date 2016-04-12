<?php

namespace Jcfk\Validators;

use Illuminate\Support\MessageBag;
use Illuminate\Validation\Factory;

abstract class AbstractValidator
{
    /**
     * @var Factory
     */
    private $validatorFactory;

    /**
     * @var MessageBag
     */
    private $errors;

    /**
     * @param Factory $validatorFactory
     */
    public function __construct(Factory $validatorFactory)
    {
        $this->validatorFactory = $validatorFactory;
        $this->errors = new MessageBag();
    }

    /**
     * @param array $data
     */
    public function validate(array $data)
    {
        $validator = $this->validatorFactory->make($data, $this->getRules(), $this->getCustomMessages());

        if ($validator->fails()) {
            $this->errors = $validator->errors();

            return false;
        }

        return true;
    }

    /**
     * @return MessageBag
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    protected function getCustomMessages()
    {
        return [];
    }

    /**
     * Rules array
     *
     * @return array
     */
    abstract protected function getRules();
}
