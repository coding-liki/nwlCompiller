<?php
declare(strict_types=1);

namespace Program;

use CodeGenerator\CodeGeneratorInterface;
use Lexer\LexerInterface;
use Parser\ParserInterface;
use Program\Constant\Errors;
use Program\Dto\CompileResult;
use Program\Dto\Error;
use Program\Exception\VoidAstTreeException;
use Program\Exception\VoidSrcException;
use Program\Exception\VoidTokensException;
use SrcProvider\SrcProviderInterface;

class Program
{
    public function __construct(
        private SrcProviderInterface $srcProvider,
        private LexerInterface $lexer,
        private ParserInterface $parser,
        private CodeGeneratorInterface $codeGenerator
    ){}

    public function compile(): CompileResult
    {
        try {
            $src        = $this->srcProvider->getSrc();
            $tokens     = $this->lexer->getTokens($src);
            $ast        = $this->parser->getAstTree($tokens);
            $executable = $this->codeGenerator->getExecutable($ast);
            return new CompileResult(true, $executable->getPath(), []);
        } catch(VoidSrcException $e){
            return $this->returnError(Errors::NO_SRC, sprintf("no src from %s", get_class($this->srcProvider)));
        } catch(VoidTokensException $e) {
            return $this->returnError(Errors::NO_TOKENS, sprintf("no tokens from %s", get_class($this->lexer)));
        } catch (VoidAstTreeException $e) {
            return $this->returnError(Errors::NO_AST_TREE, sprintf("no ast tree from %s", get_class($this->parser)));
        } catch(\Throwable $t) {
            return $this->returnError(Errors::INTERNAL, $t->getMessage());
        }
    }


    private function returnError(int $type, string $message): CompileResult
    {
        return new CompileResult(false, "", [
            new Error(
                $type,
                $message
            )
        ]);
    }
}