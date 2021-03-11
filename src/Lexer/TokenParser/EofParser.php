<?php
declare(strict_types=1);

namespace Lexer\TokenParser;


use Lexer\Token;
use Program\Constant\TokenTypes;

class EofParser implements TokenParserInterface
{
    public function parseToken(string $src): ?Token
    {
        return $src === '' ? new Token(TokenTypes::EOF, '') : null;
    }
}