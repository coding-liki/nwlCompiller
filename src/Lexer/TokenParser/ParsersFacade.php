<?php
declare(strict_types=1);

namespace Lexer\TokenParser;


use Lexer\Token;
use Program\Constant\TokenTypes;

class ParsersFacade implements TokenParserInterface
{

    /**
     * ParsersFacade constructor.
     * @param TokenParserInterface[] $parsers
     */
    public function __construct(
        private array $parsers
    ) {}

    public function parseToken(string $src): Token
    {
        foreach ($this->parsers as $parser) {
            $token = $parser->parseToken($src);
            if($token !== null){
                return $token;
            }
        }
        return new Token(TokenTypes::ERROR, $src[0] ?? '');
    }
}