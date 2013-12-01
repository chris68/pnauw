<?php

namespace frontend\models;

/**
 * This is the model class for table "tbl_incident".
 *
 * @property integer $id
 * @property string $sortkey
 * @property string $name
 * @property string $category
 * @property string $description
 * @property integer $severity
 * @property string $created_ts
 * @property string $modified_ts
 * @property string $deleted_ts
 *
 * @property Picture[] $pictures
 * @property Severity $severity
 */
class Incident extends \yii\db\ActiveRecord
{
	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return 'tbl_incident';
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['sortkey', 'name', 'category', 'description', 'severity'], 'required'],
			[['sortkey', 'name', 'category', 'description', 'created_ts', 'modified_ts', 'deleted_ts'], 'string'],
			[['severity'], 'integer']
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
			'category' => 'Category',
			'description' => 'Description',
			'severity' => 'Severity',
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
		return $this->hasMany(Picture::className(), ['incident_id' => 'id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getSeverity()
	{
		return $this->hasOne(Severity::className(), ['level' => 'severity']);
	}
	
	/**
	 * Input for a standard dropdown list for all items
	 * @return array 
	 */
	public static function dropDownList()
	{
		return ['' => ['' => '(nicht gesetzt)']] + \yii\helpers\ArrayHelper::map(self::find()->orderBy('sortkey')->all(),'id','name', 'category');
	}
	
}
