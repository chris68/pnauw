<?php

namespace frontend\models;

/**
 * This is the model class for table "tbl_visibility".
 *
 * @property string $id
 * @property string $sortkey
 * @property string $name
 * @property string $description
 * @property string $created_ts
 * @property string $modified_ts
 * @property string $deleted_ts
 *
 * @property Picture[] $pictures
 * @property Campaign[] $campaigns
 */
class Visibility extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'tbl_visibility';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['id', 'sortkey', 'name', 'description'], 'required'],
			[['id', 'sortkey', 'name', 'description', 'created_ts', 'modified_ts', 'deleted_ts'], 'string']
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
		return $this->hasMany(Picture::className(), ['visibility_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getCampaigns()
	{
		return $this->hasMany(Campaign::className(), ['visibility_id' => 'id']);
	}
	
	/**
	 * Input for a standard dropdown list for all items
	 * @return array 
	 */
	public static function dropDownList()
	{
		return \yii\helpers\ArrayHelper::map(self::find()->orderBy('sortkey')->all(),'id','name');
	}
	
}
