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
	 * @var array the HTML attributes for the container tag of this widget. The "tag" option specifies
	 * what container tag should be used. It defaults to "table" if not set.
	 */
	public $options = [];
    
	public function init()
	{
		parent::init();

        if (isset($this->image)) {
            $this->options['src'] = 'data:image/jpg;base64,' . base64_encode(hex2bin(stream_get_contents($this->image->rawdata, -1, 0)));
        } else {
			// If no image is available construct one!
			$image = new \Imagick();
			$image->newImage(600, 900, new \ImagickPixel('gray'));

			$draw = new \ImagickDraw();
			/* Font properties */
			$draw->setFont('Bookman-DemiItalic');
			$draw->setFontSize( 35 );

			/* Create text */
			$image->annotateImage($draw, 10, 20, 60, 'Es liegt kein Bild vor oder das Bild ist noch im Review');
			$image->setImageFormat('jpg');
			$rawdata = bin2hex($image->getimageblob());
			
            $this->options['src'] = 'data:image/jpg;base64,' . base64_encode(hex2bin($rawdata));
		}
	
        echo \yii\helpers\Html::tag('img','',$this->options);
    }
 
};

?>
