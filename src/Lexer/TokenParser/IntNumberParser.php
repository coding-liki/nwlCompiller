<?php
declare(strict_types=1);

namespace Lexer\TokenParser;


use Lexer\Token;
use Program\Constant\TokenTypes;

class IntNumberParser implements TokenParserInterface
{
    public function parseToken(string $src): ?Token
    {
        $found = preg_match('/^-?[1-9][\d]*( |$)/', $src, $matches);

        return $found ? new Token(TokenTypes::INT_NUMBER, trim($matches[0])): null;
    }
}