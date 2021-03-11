<?php

require_once "vendor/CodingLiki/Autoloader/autoloader.php";

$srcProvider = new SrcProvider();

$compiler = new Compiler();

$compiler->compile($srcProvider->getSrc());