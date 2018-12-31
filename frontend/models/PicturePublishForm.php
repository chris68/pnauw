<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * PicturePublishForm is the model behind the publish form.
 */
class PicturePublishForm extends Model
{

    /**
     * @var int The id of the picture
     */
    public $id;

    /**
     * @var string The visibility of the picture
     */
    public $visibility_id;

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
             ['id', 'integer'],
             ['visibility_id', 'string'],
       ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'visibility_id' => 'Sichtbarkeit',
        ];
    }

}