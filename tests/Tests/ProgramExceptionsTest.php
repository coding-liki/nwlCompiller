<?php
declare(strict_types=1);
namespace Tests;

use CodeGenerator\CodeGeneratorInterface;
use Lexer\LexerInterface;
use Lexer\Token;
use Parser\ParserInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Program\Constant\Errors;
use Program\Dto\AstTree;
use Program\Dto\Executable;
use Program\Exception\VoidAstTreeException;
use Program\Exception\VoidSrcException;
use Program\Exception\VoidTokensException;
use Program\Program;
use SrcProvider\SrcProviderInterface;

require_once __DIR__.'/../../vendor/CodingLiki/Autoloader/autoloader.php';

class ProgramExceptionsTest extends TestCase
{
    public function testNoSrcCompile(): void
    {
        $program = $this->getVoidProgramMock();
        $compileResult = $program->compile();
        self::assertFalse($compileResult->isSuccess());
        self::assertEquals(Errors::NO_SRC, $compileResult->getErrors()[0]->getType());
    }

    public function testNoTokensCompile(): void
    {
        $program = $this->getProgramMock("test", []);

        $compileResult = $program->compile();
        self::assertFalse($compileResult->isSuccess());
        self::assertEquals(Errors::NO_TOKENS, $compileResult->getErrors()[0]->getType());
    }

    public function testNoAstTreeCompile(): void
    {
        $program = $this->getProgramMock("test", [new Token(1,'test')], null);
        $compileResult = $program->compile();

        self::assertFalse($compileResult->isSuccess());
        self::assertEquals(Errors::NO_AST_TREE, $compileResult->getErrors()[0]->getType());
    }

    private function getVoidProgramMock(): Program
    {
       return $this->getProgramMock("", []);
    }

    private function getProgramMock(string $src = "", array $tokens = [] , ?AstTree $astTree = null, ?Executable $executable = null): Program
    {
        $srcProvider = $this->getSrcProviderMock($src);
        $lexer = $this->getLexerMock($src, $tokens);
        $parser = $this->getParserMock($src, $tokens, $astTree);
        $codeGenerator = $this->getCodeGeneratorMock($tokens, $astTree, $executable);

        return new Program($srcProvider, $lexer, $parser, $codeGenerator);
    }

    /**
     * @param string $src
     * @return MockObject|SrcProviderInterface
     */
    private function getSrcProviderMock(string $src): MockObject|SrcProviderInterface
    {
        $srcProvider = $this->getMockBuilder(SrcProviderInterface::class)
            ->onlyMethods([
                'getSrc'
            ])->getMock();
        $srcProvider->expects(self::once())->method('getSrc')->willReturn($src);
        return $srcProvider;
    }

    /**
     * @param string $src
     * @param array $tokens
     * @return LexerInterface|MockObject
     */
    private function getLexerMock(string $src, array $tokens): LexerInterface|MockObject
    {
        $lexer = $this->getMockBuilder(LexerInterface::class)
            ->onlyMethods([
                'getTokens'
            ])->getMock();
        $getTokensMethod = $lexer->expects(self::once())->method('getTokens');
        if ($src === "") {
            $getTokensMethod->willThrowException(new VoidSrcException());
        } else {
            $getTokensMethod->willReturn($tokens);
        }
        return $lexer;
    }

    /**
     * @param string $src
     * @param array $tokens
     * @param AstTree|null $tree
     * @return ParserInterface|MockObject
     */
    private function getParserMock(string $src, array $tokens, ?AstTree $tree): ParserInterface|MockObject
    {
        $parser = $this->getMockBuilder(ParserInterface::class)
            ->onlyMethods([
                'getAstTree'
            ])->getMock();

        $getAstTreeMethod = $parser->expects($src === "" ? self::never() : self::once())->method('getAstTree');
        if($src !== "") {
            if (empty($tokens)) {
                $getAstTreeMethod->willThrowException(new VoidTokensException());
            } else {
                $getAstTreeMethod->willReturn($tree);
            }
        }

        return $parser;
    }

    /**
     * @param array $tokens
     * @param AstTree|null $tree
     * @param Executable|null $executable
     * @return CodeGeneratorInterface|MockObject
     */
    private function getCodeGeneratorMock(array $tokens, ?AstTree $tree, ?Executable $executable): CodeGeneratorInterface|MockObject
    {
        $codeGenerator = $this->getMockBuilder(CodeGeneratorInterface::class)
            ->onlyMethods([
                'getExecutable'
            ])->getMock();

        $getAstTreeMethod = $codeGenerator->expects(empty($tokens) ? self::never() : self::once())->method('getExecutable');

        if(!empty($tokens)){
            if($tree === null){
                $getAstTreeMethod->willThrowException(new VoidAstTreeException());
            } else {
                $getAstTreeMethod->willReturn($executable);
            }
        }
        return $codeGenerator;
    }
}