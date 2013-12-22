<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * PictureModerateForm is the model behind the moderate form.
 */
class PictureModerateForm extends Model
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
	 * {@inheritdoc}
	 */
    public function rules() {
        return [
 			['id', 'integer'],
 			['visibility_id', 'string'],
       ];
    }

	/**
	 * {@inheritdoc}
	 */
    public function attributeLabels() {
        return [
            'visibility_id' => 'Sichtbarkeit',
        ];
    }

}