<?php

namespace App\Exception;

/**
 * 想定内の例外
 */
class UnexpectedException extends \Exception
{
    public function __construct(string $message = '')
    {
        parent::__construct($message);
    }
}
