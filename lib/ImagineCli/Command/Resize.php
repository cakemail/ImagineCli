<?php

namespace ImagineCli\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class Resize extends ImagineCommand
{
    const CROP_FIRST = 0;

    const RESIZE_FIRST = 1;

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

            ->addOption('cropwidth', null, InputOption::VALUE_REQUIRED, 'Width of the crop')
            ->addOption('cropheight', null, InputOption::VALUE_REQUIRED, 'height of the crop')

            ->addOption('cropfirst', null, InputOption::VALUE_NONE, 'Use to crop before resizing')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $source = $input->getArgument('source');
        $destination = $input->getArgument('destination');

        $image = $this->getImage(array('source' => $source));

        $order = $input->getOption('cropfirst')
                            ? self::CROP_FIRST : self::RESIZE_FIRST;

        $orders = array(
            self::RESIZE_FIRST => array('resize', 'crop'),
            self::CROP_FIRST => array('crop', 'resize')
        );

        foreach($orders[$order] as $action) {

            switch($action) {
                case 'resize':
                    $this->resize($image, array(
                        'width' => $input->getOption('width'),
                        'height' => $input->getOption('height')
                    ));
                    break;
                case 'crop':
                    $this->crop($image, array(
                        'cropx' => $input->getOption('cropx'),
                        'cropy' => $input->getOption('cropy'),
                        'cropwidth' => $input->getOption('cropwidth'),
                        'cropheight' => $input->getOption('cropheight'),
                    ));
                    break;
            }
        }
        $this->save($image, array('destination' => $destination));
    }

}
