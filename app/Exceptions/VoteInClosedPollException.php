<?php


namespace App\Exceptions;

use Exception;
class VoteInClosedPollException extends Exception
{
    /**
     * Create a new instance
     */
    public function __construct()
    {
        parent::__construct('Poll is closed, You can not vote anymore');
    }
}
