<?php
declare(strict_types=1);

namespace CodeGenerator;


use Program\Dto\AstTree;
use Program\Dto\Executable;
use Program\Exception\VoidAstTreeException;

interface  CodeGeneratorInterface
{

    /**
     * @param AstTree|null $ast
     * @return Executable
     *
     * @throws VoidAstTreeException
     */
    public function getExecutable(?AstTree $ast): Executable;
}