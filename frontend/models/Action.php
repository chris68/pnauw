<?php

namespace frontend\models;

/**
 * This is the model class for table "tbl_action".
 *
 * @property integer $id
 * @property string $sortkey
 * @property string $name
 * @property string $description
 * @property string $created_ts
 * @property string $modified_ts
 * @property string $deleted_ts
 *
 * @property Picture[] $pictures
 */
class Action extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'tbl_action';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['sortkey', 'name', 'description'], 'required'],
			[['sortkey', 'name', 'description', 'created_ts', 'modified_ts', 'deleted_ts'], 'string']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'sortkey' => 'Sortkey',
			'name' => 'Name',
			'description' => 'Description',
			'created_ts' => 'Created Ts',
			'modified_ts' => 'Modified Ts',
			'deleted_ts' => 'Deleted Ts',
		];
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getPictures()
	{
		return $this->hasMany(Picture::className(), ['action_id' => 'id']);
	}
	
	/**
	 * Input for a standard dropdown list for all items
	 * @return array 
	 */
	public static function dropDownList()
	{
		return ['' => '(nicht gesetzt)'] + \yii\helpers\ArrayHelper::map(self::find()->orderBy('sortkey')->all(),'id','name');
	}
	
	
}
