<?php
declare(strict_types=1);

namespace Tests\TokenParser;


use Lexer\Token;
use Lexer\TokenParser\EofParser;
use Lexer\TokenParser\IdParser;
use Lexer\TokenParser\IntNumberParser;
use Lexer\TokenParser\OneSymbolParser;
use Lexer\TokenParser\WhiteSpaceParser;
use PHPUnit\Framework\TestCase;
use Program\Constant\TokenTypes;

//require_once __DIR__.'/../../vendor/CodingLiki/Autoloader/autoloader.php';

class TokenParsersTest extends TestCase
{
    /**
     * @dataProvider idParserProvider
     * @param string $src
     * @param Token|null $token
     */
    public function testIdParser(string $src, ?Token $token): void
    {
        $tokenParser = new IdParser();

        $resultToken = $tokenParser->parseToken($src);

        self::assertEquals($token, $resultToken);
    }

    /**
     * @dataProvider intNumberParserProvider
     *
     * @param string $src
     * @param Token|null $token
     */
    public function testIntNumberParser(string $src, ?Token $token): void
    {
        $tokenParser = new IntNumberParser();

        $resultToken = $tokenParser->parseToken($src);

        self::assertEquals($token, $resultToken);
    }

    /**
     * @dataProvider eofParserProvider
     * @param string $src
     */
    public function testEofParser(string $src, ?Token $token)
    {
        $parser = new EofParser();

        $resultToken = $parser->parseToken($src);

        self::assertEquals($token, $resultToken);
    }

    /**
     * @dataProvider whiteSpaceParserProvider
     * @param string $src
     * @param Token|null $token
     */
    public function testWhiteSpaceParser(string $src, ?Token $token)
    {
        $parser = new WhiteSpaceParser();

        $resultToken = $parser->parseToken($src);

        self::assertEquals($token, $resultToken);
    }

    /**
     * @dataProvider oneSymbolParserProvider
     * @param string $src
     * @param Token|null $token
     */
    public function testOneSymbolParser(string $src, ?Token $token)
    {
        $parser = new OneSymbolParser();

        $resultToken = $parser->parseToken($src);

        self::assertEquals($token, $resultToken);
    }
    public function idParserProvider(): array
    {
        return [
            "void src" => [
                'src' => "",
                'token' => null
            ],
            "start with wordChar" => [
                'src' => "test",
                'token' => $this->getIdToken('test')
            ],
            "start with wordChar and has digits" => [
                'src' => "te13123st asddas",
                'token' => $this->getIdToken('te13123st')
            ],
            "start with digit" => [
                'src' => "1232 asdasd",
                'token' => null
            ],
            "start with digit and has wordChar" => [
                'src' => "12wdqwd32 asdasd",
                'token' => null
            ],
            "start with asterisk" => [
                'src' => "* 112 asdasd",
                'token' => null
            ],
            "start with _" => [
                'src' => "_asdasd skdjksjd",
                'token' => $this->getIdToken('_asdasd')
            ],
            "start with _ and have digits" => [
                'src' => "_asdasqwe12321d skdjksjd",
                'token' => $this->getIdToken('_asdasqwe12321d')
            ]

        ];
    }

    /**
     * @param string $value
     * @return Token
     */
    private function getIdToken(string $value): Token
    {
        return new Token(TokenTypes::ID, $value);
    }

    /**
     * @param string $value
     * @return Token
     */
    private function getIntNumberToken(string $value): Token
    {
        return new Token(TokenTypes::INT_NUMBER, $value);
    }

    public function intNumberParserProvider(): array
    {
        return [
            "void src" => [
                'src' => "",
                'token' => null
            ],
            "only digits" => [
                'src' => "213221",
                'token' => $this->getIntNumberToken('213221')
            ],
            "starts with int" => [
                'src' => "213221 kasjdj",
                'token' => $this->getIntNumberToken('213221')
            ],
            "start with wordChar" => [
                'src' => "test",
                'token' =>null
            ],
            "start with wordChar and has digits" => [
                'src' => "te13123st asddas",
                'token' => null
            ],
            "start with digit and has wordChar" => [
                'src' => "12wdqwd32 asdasd",
                'token' => null
            ],
            "start with asterisk" => [
                'src' => "* 112 asdasd",
                'token' => null
            ],
            "start with _" => [
                'src' => "_asdasd skdjksjd",
                'token' => null
            ],
            "start with _ and have digits" => [
                'src' => "_asdasqwe12321d skdjksjd",
                'token' => null
            ]
        ];
    }

    public function eofParserProvider(): array
    {
        return [
            'void' => [
                'src' => "",
                'token' => new Token(TokenTypes::EOF, "")
            ],
            'not void' => [
                'src' => "asdsad adf dsf",
                'token' => null
            ]
        ];
    }

    public function whiteSpaceParserProvider(): array
    {
        return [
            'void' => [
                'src' => '',
                'token' => null
            ],
            'not white space' => [
                'src' => 'aefdv ae wr srf',
                'token' => null
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
            'has tabs and \n and white spaces'=> [
                'src' => "\t\t\n \t   \n\t\t  sdkfjdksfj",
                'token' => new Token(TokenTypes::WHITE_SPACE_STRING, "\t\t\n \t   \n\t\t  ")
            ],
        ];
    }

    public function oneSymbolParserProvider(): array
    {
        return [
            "void src" => [
                'src' => "",
                'token' => null
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
            ]
            
        ];
    }

}