<?php
declare(strict_types=1);

namespace Program\Dto;


class Executable
{
    public function __construct(
        private string $path
    ){}

    public function getPath(): string
    {
        return $this->path;
    }
}