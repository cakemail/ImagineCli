<?php

include __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;

$console = new Application();
$console->add(new ImagineCli\Command\Resize);

$console->run();