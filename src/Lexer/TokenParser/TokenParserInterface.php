<?php
declare(strict_types=1);

namespace Lexer\TokenParser;


use Lexer\Token;

interface TokenParserInterface
{
    public function parseToken(string $src): ?Token;
}