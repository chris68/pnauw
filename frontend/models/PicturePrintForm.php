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
    public $overviewlist='none';
    public $visibility='unchanged';
    public $history='none';
    
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
            [    ['overviewmap', 'visibility', 'overviewlist', 'history'],
                'string',
            ],
        ];
    }
}
