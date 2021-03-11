<?php
declare(strict_types=1);

namespace Lexer;


use Program\Exception\VoidSrcException;

interface  LexerInterface
{

    /**
     * @param string $src
     * @return Token[]
     *
     * @throws VoidSrcException
     */
    public function getTokens(string $src): array;
}