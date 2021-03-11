<?php
declare(strict_types=1);

namespace Tests;

use CodingLiki\ShellApp\ShellApp;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use SrcProvider\SrcFromArgument;

//require_once __DIR__.'/../../vendor/CodingLiki/Autoloader/autoloader.php';

class SrcFromArgumentTest extends TestCase
{
    /**
     * @dataProvider withPathDataProvider
     * @param string $path
     */
    public function testWithPath(string $path): void
    {

        $srcProvider = new SrcFromArgument($this->getShellAppMock($path));

        $expectedSrc = '';
        if(file_exists($path)){
            $expectedSrc = file_get_contents($path);
        }

        $src = $srcProvider->getSrc();
        self::assertEquals($expectedSrc, $src);
    }

    private function getShellAppMock(string $path): MockObject|ShellApp
    {
        $app = $this->getMockBuilder(ShellApp::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getParam'])->getMock();

        $getParam = $app->expects(self::once())->method('getParam')->with('i','')->willReturn($path);

        return $app;
    }

    public function withPathDataProvider(): array
    {
        return [
            "void" => [
                "path" => ""
            ],
            "voidfile" => [
                "path" => __DIR__."/../data/src/void_src.nwl"
            ],
            "notVoidFile" => [
                "path" => __DIR__."/../data/src/not_void_src.nwl"
            ]
        ];
    }
}