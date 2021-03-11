<?php
declare(strict_types=1);

namespace Lexer\TokenParser;


use Lexer\Token;
use Program\Constant\TokenTypes;

class IdParser implements TokenParserInterface
{
    public function parseToken(string $src): ?Token
    {
        $found = preg_match('/^[a-яa-z_]+[\w]*/ui', $src, $matches);
        return $found ? new Token(TokenTypes::ID, $matches[0]) :  null;
    }
}