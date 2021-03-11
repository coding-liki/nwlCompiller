<?php
declare(strict_types=1);

namespace Program\Exception;


use Exception;

class VoidAstTreeException extends Exception
{
    public function __construct()
    {
        parent::__construct("No Ast tree");
    }
}