<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * PictureUploadForm is the model behind the contact form.
 */
class PictureUploadForm extends Model
{

    /**
     * @var string The names of the files to be uploaded
     */
    public $file_names;

	/**
	 * {@inheritdoc}
	 */
    public function rules() {
        return [
            ['file_names', 'required'],
        ];
    }

	/**
	 * {@inheritdoc}
	 */
    public function attributeLabels() {
        return [
            'file_names' => 'Hochzuladene Bilder',
        ];
    }

}