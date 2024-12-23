<?php

namespace App\Exception;

/**
 * 想定内の例外
 */
class ExpectedException extends \Exception
{
    public $redirectTo = null;

    public function __construct(?string $redirectTo = null, string $message = '')
    {
        $this->redirectTo = $redirectTo;
        parent::__construct($message);
    }
}
