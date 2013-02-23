<?php

namespace ImagineCli\Command;

use Symfony\Component\Console\Command\Command;
use Imagine\Image\ImageInterface;
use Imagine\Gd\Imagine;
use Imagine\Image\Point;
use Imagine\Image\Box;

use Exception;


class ImagineCommand extends Command
{
    /**
     * OutputInterface
     *    the output of the console application
     */
    protected $output;

    /**
     * Get an image object from a path
     *
     * @param string $path
     *    the path of the image file to open
     *
     * @return ImageInterface
     *    an image object implementing the ImageInterface
     */
    protected function getImage(array $options)
    {
        if(!isset($options['source'])) {
            $this->writeError('Source path is required');
        }

        try {
            $imagine = new Imagine;
            return $imagine->open($options['source']);

        } catch(Exception $e) {

            $this->writeError($e->getMessage());
        }
    }

    /**
     * Crop an image
     *
     * @param ImageInterface $image
     *    the image to crop
     *
     * @param array $options
     *    array containing crop options
     *    - cropx : x coordinate of top left corner of area to crop
     *    - cropy : y coordinate of top left corner of area to crop
     *    - cropwidth : width of area to crop
     *    - cropheight: height of area to crop
     */
    protected function crop(ImageInterface $image, array $options)
    {
        if($this->optionsEmpty($options)) {
            return;
        }

        $size = $image->getSize();

        $cropx = is_null($options['cropx']) ? 0 : $options['cropx'];
        $cropy = is_null($options['cropy']) ? 0 : $options['cropy'];

        $cropWidth = is_null($options['cropwidth'])
                            ? $size->getWidth() - $cropx : $options['cropwidth'];

        $cropHeight = is_null($options['cropheight'])
                            ? $size->getHeight() - $cropy : $options['cropheight'];

        try {
            $image->crop(new Point($cropx, $cropy), new Box($cropWidth, $cropHeight));

        } catch(Exception $e) {

            $this->writeError($e->getMessage());
        }
    }

    /**
     * Resize an image
     *
     * @param ImageInterface $image
     *    the image to resize
     *
     * @param array $options
     *    array containing resize options
     *    - width : width of the resulting image
     *    - heigth : heigth of the resulting image
     */
    protected function resize(ImageInterface $image, array $options)
    {
        if($this->optionsEmpty($options)) {
            return;
        }

        $size = $image->getSize();

        $width = array_key_exists('width', $options)
                        ? $options['width'] : $size->getWidth();

        $height = array_key_exists('height', $options)
                        ? $options['height'] : $size->getHeight();

        try {
            $image->resize(new Box($width, $height));

        } catch(Exception $e) {

            $this->writeError($e->getMessage());
        }
    }

    /**
     * Save an image to a file
     *
     * @param ImageInterface $image
     *    the image to crop
     *
     * @param array $options
     *    array of options
     *    - destination: destination save path
     */
    protected function save(ImageInterface $image, array $options)
    {
        if(!isset($options['destination'])) {
            $this->writeError('Destination path is required');
        }

        try {
            $image->save($options['destination']);

        } catch(Exception $e) {

            $this->writeError($e->getMessage());
        }
    }

    /**
     * Check of array of options is empty
     *
     * @param array $options
     *    array of options
     *
     * @return bool
     * whether array is empty
     */
    protected function optionsEmpty(array $options)
    {
        $unique = array_unique($options);

        return empty($options) || (count($unique) == 1 && is_null(array_pop($unique)));
    }

    /**
     * Write an error to the output
     *
     * @param string $error
     *    the error message
     */
    protected function writeError($error)
    {
        $this->output->writeln(sprintf('<error>%s</error>', $error));
        exit(1);
    }

}