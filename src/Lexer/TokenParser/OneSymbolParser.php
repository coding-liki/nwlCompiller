<?php
declare(strict_types=1);

namespace Lexer\TokenParser;


use Lexer\Token;
use Program\Constant\TokenTypes;

class OneSymbolParser implements TokenParserInterface
{
    private const SYMBOL_TO_TYPE_MAP = [
        '=' => TokenTypes::EQUALS,
        '(' => TokenTypes::LEFT_BRACKET,
        ')' => TokenTypes::RIGHT_BRACKET,
        '{' => TokenTypes::LEFT_BRACE,
        '}' => TokenTypes::RIGHT_BRACE,
        '[' => TokenTypes::LEFT_SQR_BRACKET,
        ']' => TokenTypes::RIGHT_SQR_BRACKET,
        '<' => TokenTypes::LESS_THAN,
        '>' => TokenTypes::MORE_THAN,
        ';' => TokenTypes::SEMICOLON,
        '.' => TokenTypes::DOT,
        '+' => TokenTypes::PLUS,
        '-' => TokenTypes::MINUS,
        '*' => TokenTypes::ASTERISK,
        '/' => TokenTypes::SLASH,
        '\\' => TokenTypes::BACKSLASH,
        ',' => TokenTypes::COMMA,
        ':' => TokenTypes::COLON,
        '"' => TokenTypes::DOUBLE_QUOTES,
        "'" => TokenTypes::QUOTES
    ];
    public function parseToken(string $src): ?Token
    {
        $symbol = $src[0] ?? null;
        $type   = self::SYMBOL_TO_TYPE_MAP[$symbol] ?? null;
        if($type !== null){
            return new Token($type, $symbol);
        }

        return null;
    }
}