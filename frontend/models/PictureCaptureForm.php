<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * PictureCaptureForm is the model behind the capture form.
 */
class PictureCaptureForm extends Model
{

	/**
     * @var string The name of the file to be uploaded/captured
     */
    public $file_name;

	/**
	 * @var file The file handle of the file to be uploaded/captured
	 */
	public $file_handle;

	/**
	 * {@inheritdoc}
	 */
    public function rules() {
        return [
 			['file_handle', 'file', 'maxFiles' => 1, 'maxSize' => 1048576, 'types' => 'jpg'],
       ];
    }

	/**
	 * {@inheritdoc}
	 */
    public function attributeLabels() {
        return [
            'file_name' => 'Aufgenommenes Bild',
            'file_handle' => 'Aufgenommenes Bild (Datei)',
        ];
    }

}