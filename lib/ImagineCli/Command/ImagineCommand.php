<?php

namespace ImagineCli\Command;

use Symfony\Component\Console\Command\Command;
use Imagine\Gd\Imagine;
use Exception;

class ImagineCommand extends Command
{
    protected $output;

    protected function getImage($path)
    {
        try {
            $imagine = new Imagine;
            return $imagine->open($path);
        } catch(Exception $e) {
            $this->output->writeln(sprintf('<error>%s</error>', $e->getMessage()));
        }
    }

}