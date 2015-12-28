<?php

namespace frontend\models;

use Yii;
use yii\base\Model;

/**
 * KMLUploadForm is the model behind the kml upload form.
 */
class KmlUploadForm extends Model
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
             ['file_handles', 'file', 'maxFiles' => 5, 'maxSize' => 10485760, /*'mimeTypes' => 'application/vnd.google-earth.kml+xml',  */ 'skipOnEmpty' => false],
       ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'file_names' => 'Hochzuladene KML-Daten',
            'file_handles' => 'Hochzuladene KML-Daten (Dateien)',
        ];
    }

}