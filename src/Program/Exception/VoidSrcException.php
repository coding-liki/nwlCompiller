<?php
declare(strict_types=1);

namespace Program\Exception;


use Exception;

class VoidSrcException extends Exception
{
    public function __construct()
    {
        parent::__construct("No src");
    }
}