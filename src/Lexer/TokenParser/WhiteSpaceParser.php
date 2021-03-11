<?php
declare(strict_types=1);

namespace Lexer\TokenParser;


use Lexer\Token;
use Program\Constant\TokenTypes;

class WhiteSpaceParser implements TokenParserInterface
{
    public function parseToken(string $src): ?Token
    {
        $found = preg_match('/^\s+/', $src, $matches);

        return $found ? new Token(TokenTypes::WHITE_SPACE_STRING,$matches[0]) :  null;
    }
}