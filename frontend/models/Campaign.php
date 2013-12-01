<?php

namespace frontend\models;

/**
 * This is the model class for table "tbl_campaign".
 *
 * @property integer $id
 * @property integer $owner_id
 * @property string $name
 * @property string $description
 * @property string $running_from
 * @property string $running_until
 * @property string $visibility_id
 * @property string $loc_path
 * @property string $created_ts
 * @property string $modified_ts
 * @property string $released_ts
 * @property string $deleted_ts
 *
 * @property Picture[] $pictures
 * @property User $owner
 * @property Visibility $visibility
 */
class Campaign extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'tbl_campaign';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['owner_id', 'name', 'description', 'visibility_id'], 'required'],
			[['owner_id'], 'integer'],
			[['name', 'description', 'visibility_id', 'loc_path', 'created_ts', 'modified_ts', 'released_ts', 'deleted_ts'], 'string'],
			[['running_from', 'running_until'], 'safe']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'owner_id' => 'Owner ID',
			'name' => 'Name',
			'description' => 'Description',
			'running_from' => 'Running From',
			'running_until' => 'Running Until',
			'visibility_id' => 'Visibility ID',
			'loc_path' => 'Loc Path',
			'created_ts' => 'Created Ts',
			'modified_ts' => 'Modified Ts',
			'released_ts' => 'Released Ts',
			'deleted_ts' => 'Deleted Ts',
		];
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getPictures()
	{
		return $this->hasMany(Picture::className(), ['campaign_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getOwner()
	{
		return $this->hasOne(User::className(), ['id' => 'owner_id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getVisibility()
	{
		return $this->hasOne(Visibility::className(), ['id' => 'visibility_id']);
	}

	/**
	 * Input for a standard dropdown list for all items
	 * @return array 
	 */
	public static function dropDownList()
	{
		return ['' => '(nicht gesetzt)'] + \yii\helpers\ArrayHelper::map(self::find()->orderBy('created_ts')->all(),'id','name');
	}
	
	
}
