<?php
declare(strict_types=1);

namespace Lexer;


class Token
{
    public function __construct(
        private int $type,
        private string $value
    ){}

    /**
     * @return int
     */
    public function getType(): int
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}