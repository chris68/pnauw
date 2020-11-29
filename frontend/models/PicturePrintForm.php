<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PicturePrintForm represents the model behind the print parameters for printing pictures
 */
class PicturePrintForm extends Model
{
    public $overviewmap='none';
    public $visibility='unchanged';
    
    /**
     * @inheritdoc
     */
    public function formName()
    {
        return 'p';
    }
    
    public function rules()
    {
        return [
            [    ['overviewmap', 'visibility', ],
                'string',
            ],
        ];
    }
}
