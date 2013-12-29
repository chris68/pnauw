<?php

namespace frontend\models;

/**
 * This is the model class for table "tbl_citation".
 *
 * @property integer $id
 * @property integer $owner_id
 * @property string $name
 * @property string $description
 * @property string $created_ts
 * @property string $modified_ts
 * @property string $released_ts
 * @property string $deleted_ts
 *
 * @property Picture[] $pictures
 * @property User $owner
 */
class Citation extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'tbl_citation';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['owner_id', 'name', 'description'], 'required'],
			[['owner_id'], 'integer'],
			[['name', 'description', 'created_ts', 'modified_ts', 'released_ts', 'deleted_ts'], 'string']
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
			'created_ts' => 'Created Ts',
			'modified_ts' => 'Modified Ts',
			'released_ts' => 'Released Ts',
			'deleted_ts' => 'Deleted Ts',
		];
	}

	/**
	 * Scope for retrieving the dropdown list
	 * @param ActiveQuery $query
	 */
	public static function dropdownScope($query)
	{
		$query->andWhere("{{%citation}}.owner_id = :owner", [':owner' => \Yii::$app->user->id]);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getPictures()
	{
		return $this->hasMany(Picture::className(), ['citation_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getOwner()
	{
		return $this->hasOne(User::className(), ['id' => 'owner_id']);
	}
	
	/**
	 * Input for a standard dropdown list for all items
	 * @return array 
	 */
	public static function dropDownList()
	{
		return ['' => '(nicht gesetzt)'] + \yii\helpers\ArrayHelper::map(self::find()->dropdownScope()->orderBy('created_ts')->all(),'id','name');
	}
	
}
