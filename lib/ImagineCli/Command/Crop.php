<?php

namespace ImagineCli\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class Crop extends ImagineCommand
{
    protected function configure()
    {
        $this
            ->setName('crop')
            ->setDescription('Crop, an image')
            
            ->addArgument('source', InputArgument::REQUIRED, 'Path to original image file')
            ->addArgument('destination', InputArgument::REQUIRED, 'Path to destination file')

            ->addOption('cropx', null, InputOption::VALUE_REQUIRED, 'X coordinate to start crop')
            ->addOption('cropy', null, InputOption::VALUE_REQUIRED, 'Y coordinate to start crop')

            ->addOption('cropwidth', null, InputOption::VALUE_REQUIRED, 'Width of the crop')
            ->addOption('cropheight', null, InputOption::VALUE_REQUIRED, 'height of the crop')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $source = $input->getArgument('source');
        $destination = $input->getArgument('destination');

        $image = $this->getImage(array('source' => $source));

        $this->crop($image, array(
            'cropx' => $input->getOption('cropx'),
            'cropy' => $input->getOption('cropy'),
            'cropwidth' => $input->getOption('cropwidth'),
            'cropheight' => $input->getOption('cropheight'),
        ));

        $this->save($image, array('destination' => $destination));
    }

}
