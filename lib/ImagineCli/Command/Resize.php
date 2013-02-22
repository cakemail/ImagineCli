<?php

namespace ImagineCli\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Imagine\Image\Box;
use Imagine\Image\Point;
use Imagine\Image\ImageInterface;


class Resize extends ImagineCommand
{
    protected function configure()
    {
        $this
            ->setName('resize')
            ->setDescription('Resize, and optionally crop, an image')
            
            ->addArgument('source', InputArgument::REQUIRED, 'Path to original image file')
            ->addArgument('destination', InputArgument::REQUIRED, 'Path to destination file')

            ->addOption('width', null, InputOption::VALUE_REQUIRED, 'The width of the resized image')
            ->addOption('height', null, InputOption::VALUE_REQUIRED, 'The height of the resized image')

            ->addOption('cropx', null, InputOption::VALUE_REQUIRED, 'X coordinate to start crop')
            ->addOption('cropy', null, InputOption::VALUE_REQUIRED, 'Y coordinate to start crop')

            // ->addOption('cropwidth', null, InputOption::VALUE_REQUIRED, 'Y coordinate to start crop')
            // ->addOption('cropwidth', null, InputOption::VALUE_REQUIRED, 'Y coordinate to start crop')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $source = $input->getArgument('source');
        $destination = $input->getArgument('destination');


        // resize
        $width = $input->getOption('width');
        $height = $input->getOption('height');

        $cropx = $input->getOption('cropx');
        $cropy = $input->getOption('cropy');

        $image = $this->getImage($source);


        // crop
        $image->crop(new Point(10, 10), new Box(100, 100));


        $image->resize(new Box($width, $height));


        $image->save($destination);
    }

}
