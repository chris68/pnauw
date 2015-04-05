<?php

namespace frontend\widgets;

/**
 * Renders an image
 */
class ImageRenderer extends \yii\base\Widget
{
 
    /**
     *
     * @var frontend\models\Image The image object to be rendered
     */
    public $image;
 
    /**
     *
     * @var string The size of the image: 'thumbnail', 'small', 'medium' or 'large'
     */
    public $size = 'small';
 
    /**
     * @var array the HTML attributes for the container tag of this widget.
     */
    public $options = [];
    
    public function init()
    {
        parent::init();

        if (isset($this->image)) {
            $this->options['src'] = 'data:image/jpg;base64,' . base64_encode(hex2bin(stream_get_contents($this->image->rawdata, -1, 0)));
            $this->options['alt'] = 'Bild des Vorfalls';
        } else {
            // If no image is available construct one!
            $image = new \Imagick();
            $draw = new \ImagickDraw();
            $draw->setFont('AvantGarde-BookOblique');
            switch ($this->size) {
                // According to: http://flickrj.sourceforge.net/api/com/aetrion/flickr/photos/Size.html
                case 'thumbnail':
                    $image->newImage(75, 100, new \ImagickPixel('gray'));
                    $draw->setFontSize(11);
                    $offset = 20;
                    break;
                case 'small':
                    $image->newImage(180, 240, new \ImagickPixel('gray'));
                    $draw->setFontSize(30);
                    $offset = 60;
                    break;
                case 'medium':
                    $image->newImage(375, 500, new \ImagickPixel('gray'));
                    $draw->setFontSize(65);
                    $offset = 120;
                    break;
                case 'large':
                    $image->newImage(768, 1024, new \ImagickPixel('gray'));
                    $draw->setFontSize(130);
                    $offset = 250;
                    break;
            }


            /* Create text */
            $image->annotateImage($draw, 10, $offset, 0, "Ohne Bild\n\n(Bild noch\nim Review)");
            $image->setImageFormat('jpg');
            $rawdata = bin2hex($image->getimageblob());
            
            $this->options['src'] = 'data:image/jpg;base64,' . base64_encode(hex2bin($rawdata));
            $this->options['alt'] = 'Bild des Vorfalls';
        }
    
        echo \yii\helpers\Html::tag('img','',$this->options);
    }
 
};

?>
