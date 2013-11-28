<?php

namespace frontend\models;

/**
 * This is the model class for table "tbl_image".
 *
 * @property integer $id
 * @property string $rawdata
 *
 */

class Image extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%image}}';
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'rawdata' => 'Rawdata',
		];
	}

}
