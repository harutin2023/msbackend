<?php

namespace App\Application\Validator;

abstract class Validator
{
    /**
     * @return bool
     */
    public abstract function isValid(): bool;
}
