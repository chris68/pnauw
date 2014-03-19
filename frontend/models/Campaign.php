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
	 * Quick hack to support the attribute without model changes
	 */
	public $availability_id = 'trusted';
	
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
				// @todo: Enable here later the moderation
				//'class' => 'common\behaviors\EnsureOwnershipWithModeration',
				'ownerAttribute' => 'owner_id',
				'ensureOnFind' => false,
			],
		];
	}

	/**
	 * Validator to check if the user may set the visibility to public
	 */
	public function validateVisibilityConsistency($attribute, $params)
	{
		if ((strpos($this->visibility_id,'public') !== false) && !\Yii::$app->user->checkAccess('trusted')) {
			$this->addError('visibility_id', 'Sie dürfen als noch nicht vertrauenswürdiger Nutzer derzeit leider generell noch keine Kampagnen veröffentlichen!');
		}
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		return [
			[['name', 'description', 'visibility_id', 'availability_id', 'running_from', 'running_until'], 'required'],
			[['name', 'description', 'visibility_id', 'availability_id', /*'loc_path',*/ ], 'string'],
			['visibility_id',  'validateVisibilityConsistency', ],
			[['running_from', 'running_until'], 'date']
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
			'running_from' => 'Startdatum',
			'running_until' => 'Enddatum',
			'visibility_id' => 'Sichtbarkeit',
			'availability_id' => 'Verfügbarkeit',
			'loc_path' => 'Ort (Pfad)',
			'created_ts' => 'Angelegt am',
			'modified_ts' => 'Verändert am',
			'released_ts' => 'Freigegeben am',
			'deleted_ts' => 'Gelöscht am',
		];
	}

	/**
	 * {@inheritdoc}
	 */
    public static function createQuery()
    {
        return new CampaignQuery(['modelClass' => get_called_class()]);
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
		return ['' => '(nicht gesetzt)'] + \yii\helpers\ArrayHelper::map(self::find()->dropdownScope()->orderBy('created_ts')->all(),'id','name');
	}
	
	
}
