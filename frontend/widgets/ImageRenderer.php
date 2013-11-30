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
	        $this->options['alt'] = 'Bild noch im Review';
		}
	
        echo \yii\helpers\Html::tag('img','',$this->options);
    }
 
};

?>
