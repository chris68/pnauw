<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * PictureUploadForm is the model behind the upload form.
 */
class PictureUploadForm extends Model
{

	/**
     * @var string[] The names of the files to be uploaded
     */
    public $file_names;

	/**
	 * @var file[] The file handles of the files to be uploaded
	 */
	public $file_handles;

	/**
	 * {@inheritdoc}
	 */
    public function rules() {
        return [
			['file_names', 'required', ], 
 			['file_handles', 'file', 'maxFiles' => 50, 'maxSize' => 1048576, 'extensions' => 'jpg', 'mimeTypes' => 'image/jpeg',  'skipOnEmpty' => false],
       ];
    }

	/**
	 * {@inheritdoc}
	 */
    public function attributeLabels() {
        return [
            'file_names' => 'Hochzuladene Bilder',
            'file_handles' => 'Hochzuladene Bilder (Dateien)',
        ];
    }

}