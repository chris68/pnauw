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
	public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => 'yii\behaviors\AutoTimestamp',
				'attributes' => [
					\yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_ts', 'modified_ts'],
					\yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'modified_ts',
				],
				'timestamp' => new \yii\db\Expression('NOW()'),
			],
			'EnsureOwnership' => [
				'class' => 'common\behaviors\EnsureOwnership',
				'ownerAttribute' => 'owner_id',
				'ensureOnFind' => true,
			],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name', 'description'], 'required'],
			[['name', 'description', ], 'string']
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'owner_id' => 'Besitzer',
			'name' => 'Name',
			'description' => 'Beschreibung',
			'created_ts' => 'Angelegt am',
			'modified_ts' => 'Verändert am',
			'released_ts' => 'Freigegeben am',
			'deleted_ts' => 'Gelöscht am',
		];
	}

	/**
	 * Scope for the owner 
	 * @param ActiveQuery $query
	 */
	public static function ownerScope($query)
	{
		$query->andWhere("{{%citation}}.owner_id = :owner", [':owner' => \Yii::$app->user->id]);
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
