<?php
declare(strict_types=1);

namespace Parser;


use Program\Dto\AstTree;
use Program\Exception\VoidTokensException;

interface  ParserInterface
{

    /**
     * @param array $tokens
     * @return AstTree|null
     *
     * @throws VoidTokensException
     */
    public function getAstTree(array $tokens): ?AstTree;
}