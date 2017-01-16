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
            $image = new \Imagick(\Yii::getAlias('@webroot').'/img/pnauw.jpeg');
            $image->scaleimage(0, 200);
            $image->setImageFormat('jpg');
            $rawdata = bin2hex($image->getimageblob());
            
            $this->options['src'] = 'data:image/jpg;base64,' . base64_encode(hex2bin($rawdata));
            $this->options['alt'] = 'Standardbild, weil kein Bild des Vorfalls vorhanden oder dies noch Genehmigung ist';
        }
    
        echo \yii\helpers\Html::tag('img','',$this->options);
    }
 
};

?>
