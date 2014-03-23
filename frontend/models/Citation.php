<?php

namespace frontend\models;

/**
 * This is the model class for table "tbl_citation".
 *
 * @property integer $id
 * @property integer $owner_id
 * @property string $name
 * @property string $type Either 'citation' or 'complaint'
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
				'class' => 'yii\behaviors\TimestampBehavior',
				'attributes' => [
					\yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_ts', 'modified_ts'],
					\yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => 'modified_ts',
				],
				'value' => new \yii\db\Expression('NOW()'),
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
			[['name', 'description', 'type', ], 'required'],
			[['name', 'description', 'type', ], 'string']
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
			'description' => 'Zusatzinformationen',
			'type' => 'Anzeigentyp',
			'created_ts' => 'Angelegt am',
			'modified_ts' => 'Verändert am',
			'released_ts' => 'Freigegeben am',
			'deleted_ts' => 'Gelöscht am',
		];
	}

	/**
	 * {@inheritdoc}
	 */
    public static function createQuery($config = [])
    {
        $config['modelClass'] = get_called_class();
        return new CitationQuery($config);
    }
	
	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getPictures()
	{
		return $this->hasMany(Picture::className(), ['citation_id' => 'id'])->
			orderBy(['vehicle_country_code' => SORT_ASC ,'vehicle_reg_plate'  => SORT_ASC, 'taken' => SORT_ASC, ]);
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
	
	/**
	 * Input for a standard dropdown list for the type of a citation
	 * @return array 
	 */
	public static function dropDownListForType()
	{
		return ['' => '(nicht gesetzt)', 'citation' => 'rechtsverbindliche Anzeige', 'complaint' => 'unverbindliche Beschwerde'];
	}
	
	/**
	 * Output the type of the citation
	 * @return string
	 */
	public function encodeType()
	{
		return $this->dropDownListForType()[$this->type];
	}
}
