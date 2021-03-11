<?php
declare(strict_types=1);

namespace Program\Dto;


class Error
{
    public function __construct(
        private int $type,
        private string $message
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
    public function getMessage(): string
    {
        return $this->message;
    }
}