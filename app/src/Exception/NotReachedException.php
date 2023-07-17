<?php

namespace App\Exception;

use Exception;

class NotReachedException extends Exception
{
    protected $message = 'This action should not be reached, contact dev team';
}