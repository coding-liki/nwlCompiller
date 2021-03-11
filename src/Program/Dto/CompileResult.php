<?php
declare(strict_types=1);

namespace Program\Dto;


class CompileResult
{
    /**
     * CompileResult constructor.
     * @param bool $success
     * @param string $executablePath
     * @param Error[] $errors
     */
    public function __construct(
        private bool $success,
        private string $executablePath,
        private array $errors,
    ){}

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return string
     */
    public function getExecutablePath(): string
    {
        return $this->executablePath;
    }

    /**
     * @return Error[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}