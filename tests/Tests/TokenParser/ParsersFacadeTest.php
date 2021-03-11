<?php
declare(strict_types=1);

namespace Tests\TokenParser;


use Lexer\Token;
use Lexer\TokenParser\EofParser;
use Lexer\TokenParser\IdParser;
use Lexer\TokenParser\IntNumberParser;
use Lexer\TokenParser\OneSymbolParser;
use Lexer\TokenParser\ParsersFacade;
use Lexer\TokenParser\WhiteSpaceParser;
use PHPUnit\Framework\TestCase;
use Program\Constant\TokenTypes;

class ParsersFacadeTest extends TestCase
{

    /**
     * @dataProvider parseTokenProvider
     * @param string $src
     * @param Token $token
     */
    public function testParseToken(string $src, Token $token)
    {
        $facade = new ParsersFacade([
            new WhiteSpaceParser(),
            new OneSymbolParser(),
            new IntNumberParser(),
            new IdParser(),
            new EofParser()
        ]);

        $resultToken = $facade->parseToken($src);

        self::assertEquals($token, $resultToken);
    }

    public function parseTokenProvider()
    {
        return [
            "void src" => [
                'src' => "",
                'token' => new Token(TokenTypes::EOF, '')
            ],
            "only =" => [
                'src' => '=',
                'token' => new Token(TokenTypes::EQUALS, '=')
            ],
            "=" => [
                'src' => '=  asdsa',
                'token' => new Token(TokenTypes::EQUALS, '=')
            ],
            'only (' => [
                'src' => '(',
                'token' => new Token(TokenTypes::LEFT_BRACKET, '(')
            ],
            '(' => [
                'src' => '( asdsa',
                'token' => new Token(TokenTypes::LEFT_BRACKET, '(')
            ],
            'only )' => [
                'src' => ')',
                'token' => new Token(TokenTypes::RIGHT_BRACKET, ')')
            ],
            ')' => [
                'src' => ') asdsa',
                'token' => new Token(TokenTypes::RIGHT_BRACKET, ')')
            ],
            'only {' => [
                'src' => '{',
                'token' => new Token(TokenTypes::LEFT_BRACE, '{')
            ],
            '{' => [
                'src' => '{ asdsa',
                'token' => new Token(TokenTypes::LEFT_BRACE, '{')
            ],
            'only }' => [
                'src' => '}',
                'token' => new Token(TokenTypes::RIGHT_BRACE, '}')
            ],
            '}' => [
                'src' => '} asdsa',
                'token' => new Token(TokenTypes::RIGHT_BRACE, '}')
            ],
            'only [' => [
                'src' => '[',
                'token' => new Token(TokenTypes::LEFT_SQR_BRACKET, '[')
            ],
            '[' => [
                'src' => '[ asdsa',
                'token' => new Token(TokenTypes::LEFT_SQR_BRACKET, '[')
            ],
            'only ]' => [
                'src' => ']',
                'token' => new Token(TokenTypes::RIGHT_SQR_BRACKET, ']')
            ],
            ']' => [
                'src' => '] asdsa',
                'token' => new Token(TokenTypes::RIGHT_SQR_BRACKET, ']')
            ],
            'only <' => [
                'src' => '<',
                'token' => new Token(TokenTypes::LESS_THAN, '<')
            ],
            '<' => [
                'src' => '< asdsa',
                'token' => new Token(TokenTypes::LESS_THAN, '<')
            ],
            'only ;' => [
                'src' => ';',
                'token' => new Token(TokenTypes::SEMICOLON, ';')
            ],
            ';' => [
                'src' => '; asdsa',
                'token' => new Token(TokenTypes::SEMICOLON, ';')
            ],
            'only .' => [
                'src' => '.',
                'token' => new Token(TokenTypes::DOT, '.')
            ],
            '.' => [
                'src' => '. asdsa',
                'token' => new Token(TokenTypes::DOT, '.')
            ],
            'only +' => [
                'src' => '+',
                'token' => new Token(TokenTypes::PLUS, '+')
            ],
            '+' => [
                'src' => '+ asdsa',
                'token' => new Token(TokenTypes::PLUS, '+')
            ],
            'only -' => [
                'src' => '-',
                'token' => new Token(TokenTypes::MINUS, '-')
            ],
            '-' => [
                'src' => '- asdsa',
                'token' => new Token(TokenTypes::MINUS, '-')
            ],
            'only *' => [
                'src' => '*',
                'token' => new Token(TokenTypes::ASTERISK, '*')
            ],
            '*' => [
                'src' => '* asdsa',
                'token' => new Token(TokenTypes::ASTERISK, '*')
            ],
            'only /' => [
                'src' => '/',
                'token' => new Token(TokenTypes::SLASH, '/')
            ],
            '/' => [
                'src' => '/ asdsa',
                'token' => new Token(TokenTypes::SLASH, '/')
            ],
            'only \\' => [
                'src' => '\\',
                'token' => new Token(TokenTypes::BACKSLASH, '\\')
            ],
            '\\' => [
                'src' => '\\ asdsa',
                'token' => new Token(TokenTypes::BACKSLASH, '\\')
            ],
            'only ,' => [
                'src' => ',',
                'token' => new Token(TokenTypes::COMMA, ',')
            ],
            ',' => [
                'src' => ', asdsa',
                'token' => new Token(TokenTypes::COMMA, ',')
            ],
            'only :' => [
                'src' => ':',
                'token' => new Token(TokenTypes::COLON, ':')
            ],
            ':' => [
                'src' => ': asdsa',
                'token' => new Token(TokenTypes::COLON, ':')
            ],
            'only "' => [
                'src' => '"',
                'token' => new Token(TokenTypes::DOUBLE_QUOTES, '"')
            ],
            '"' => [
                'src' => '" asdsa',
                'token' => new Token(TokenTypes::DOUBLE_QUOTES, '"')
            ],
            'only \'' => [
                'src' => '\'',
                'token' => new Token(TokenTypes::QUOTES, '\'')
            ],
            '\'' => [
                'src' => '\' asdsa',
                'token' => new Token(TokenTypes::QUOTES, '\'')
            ],
            'one white space' => [
                'src' => ' asdas',
                'token' => new Token(TokenTypes::WHITE_SPACE_STRING, ' ')
            ],
            'more than one white spaces' => [
                'src' => '  alskdakd',
                'token' => new Token(TokenTypes::WHITE_SPACE_STRING, '  ')
            ],
            'start with \n and has white spaces' => [
                'src' => '
                ssdsd',
                'token' => new Token(TokenTypes::WHITE_SPACE_STRING, '
                ')
            ],
            'has tabs and \n and white spaces' => [
                'src' => "\t\t\n \t   \n\t\t  sdkfjdksfj",
                'token' => new Token(TokenTypes::WHITE_SPACE_STRING, "\t\t\n \t   \n\t\t  ")
            ],
            "only digits" => [
                'src' => "213221",
                'token' => new Token(TokenTypes::INT_NUMBER, '213221')
            ],
            "starts with int" => [
                'src' => "213221 kasjdj",
                'token' =>new Token(TokenTypes::INT_NUMBER, '213221')
            ],
            "start with wordChar" => [
                'src' => "test",
                'token' => new Token(TokenTypes::ID, 'test')
            ],
            "start with wordChar and has digits" => [
                'src' => "te13123st asddas",
                'token' => new Token(TokenTypes::ID, 'te13123st')
            ],
            "start with _" => [
                'src' => "_asdasd skdjksjd",
                'token' => new Token(TokenTypes::ID, '_asdasd')
            ],
            "start with _ and have digits" => [
                'src' => "_asdasqwe12321d skdjksjd",
                'token' => new Token(TokenTypes::ID, '_asdasqwe12321d')
            ]

        ];

    }
}