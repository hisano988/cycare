<?php

namespace App\Exception;

use Exception;

class PredictException extends Exception
{
    public function __construct($message = '')
    {
        parent::__construct($message);
    }
}
