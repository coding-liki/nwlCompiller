<?php
declare(strict_types=1);

namespace SrcProvider;


use CodingLiki\ShellApp\ShellApp;

class SrcFromArgument implements SrcProviderInterface
{
    public function __construct(
        private ShellApp $app
    ){}

    public function getSrc(): string
    {
        $srcPath = $this->app->getParam("i", "");

        if(file_exists($srcPath)) {
            return file_get_contents($srcPath);
        }

        return "";
    }
}