<?php

namespace frontend\models;

use yii\db\ActiveQuery;

/**
 * This is the model class for table "tbl_picture".
 *
 * @property integer $id
 * @property integer $owner_id
 * @property string $name
 * @property string $description
 * @property string $taken
 * @property string $org_loc_lat
 * @property string $org_loc_lng
 * @property string $loc_lat
 * @property string $loc_lng
 * @property string $loc_path
 * @property string $loc_formatted_addr
 * @property integer $original_image_id
 * @property integer $small_image_id
 * @property integer $medium_image_id
 * @property integer $thumbnail_image_id
 * @property integer $blurred_small_image_id
 * @property integer $blurred_medium_image_id
 * @property integer $blurred_thumbnail_image_id
 * @property integer $clip_x
 * @property integer $clip_y
 * @property integer $clip_size
 * @property string $visibility_id
 * @property string $vehicle_country_code
 * @property string $vehicle_reg_plate
 * @property string $citation_affix
 * @property integer $action_id
 * @property integer $incident_id
 * @property integer $citation_id
 * @property integer $campaign_id
 * @property string $created_ts
 * @property string $modified_ts
 * @property string $deleted_ts
 *
 * @property User $owner
 * @property Image $originalImage
 * @property Image $smallImage
 * @property Image $mediumImage
 * @property Image $thumbnailImage
 * @property Image $blurredSmallImage
 * @property Image $blurredMediumImage
 * @property Image $blurredThumbnailImage
 * @property Visibility $visibility
 * @property VehicleCountry $vehicleCountryCode
 * @property Action $action
 * @property Incident $incident
 * @property Citation $citation
 * @property Campaign $campaign
 */
class Picture extends \yii\db\ActiveRecord
{

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%picture}}';
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
				'ensureOnFind' => false,
			],
		];
	}

	/**
	 * check if country is filled if reg_plate is filled 
	 */
	public function checkVehiclePlateConsistency($attribute, $params)
	{
		if (!empty($this->vehicle_reg_plate) and empty($this->vehicle_country_code))
			$this->addError('vehicle_country_code', 'Das Land des eingetragenen Kfz-Kennzeichens muss angegeben werden.');
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		// It is utmost important that only attributes which a safe to be mass assigned are listed here!
		// owner_id and the whole image_ids certainly should not be changed by the user!
		return [
			['vehicle_country_code', 'default', 'value' => NULL],
			['action_id', 'default', 'value' => NULL],
			['incident_id', 'default', 'value' => NULL],
			['citation_id', 'default', 'value' => NULL],
			['campaign_id', 'default', 'value' => NULL],
			[['name', 'clip_x', 'clip_y', 'clip_size', 'visibility_id'], 'required'],
			[['clip_x', 'clip_y', 'clip_size', 'action_id', 'incident_id', 'citation_id', 'campaign_id'], 'integer'],
			[['name', 'description', 'loc_path', 'loc_formatted_addr', 'visibility_id', 'vehicle_country_code', 'vehicle_reg_plate', 'citation_affix',], 'string'],
			[['loc_lat', 'loc_lng',], 'double'],
			['vehicle_reg_plate', \common\validators\ConvertToUppercase::className()],
			['vehicle_country_code', 'checkVehiclePlateConsistency', 'skipOnEmpty' => false,],
		];
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios()
	{
		return parent::scenarios();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'owner_id' => 'Eigner',
			'name' => 'Bildname',
			'description' => 'Beschreibung',
			'taken' => 'Aufgenommen am',
			'org_loc_lat' => 'Org Loc Lat',
			'org_loc_lng' => 'Org Loc Lng',
			'loc_lat' => 'Breite (lat.)',
			'loc_lng' => 'Länge (long.)',
			'loc_path' => 'Ort (Pfad)',
			'loc_formatted_addr' => 'Ortsangabe',
			'original_image_id' => 'Original Image',
			'small_image_id' => 'Small Image',
			'medium_image_id' => 'Medium Image',
			'thumbnail_image_id' => 'Thumbnail Image',
			'blurred_small_image_id' => 'Blurred Small Image',
			'blurred_medium_image_id' => 'Blurred Medium Image',
			'blurred_thumbnail_image_id' => 'Blurred Thumbnail Image',
			'visibility_id' => 'Sichtbarkeit',
			'vehicle_country_code' => 'Kfz-Ländercode',
			'vehicle_reg_plate' => 'Kennzeichen',
			'citation_affix' => 'Anzeigenzusatz',
			'action_id' => 'Maßnahme',
			'incident_id' => 'Vorfall',
			'citation_id' => 'Anzeige',
			'campaign_id' => 'Kampagne',
			'created_ts' => 'Hochgeladen am',
			'modified_ts' => 'Geändert am',
			'deleted_ts' => 'Gelöscht am',
			
			// @Todo: Check whether still needed
			'visibility___name' => 'Sichtbarkeit',
			'incident___name' => 'Vorfall',
			'citation__name' => 'Anzeige',
			'action__name' => 'Maßnahme',
		];
	}

	/**
	 * @param ActiveQuery $query
	 */
	public static function ownerScope($query)
	{
		$query->andWhere("owner_id = :owner", [':owner' => \Yii::$app->user->id]);
	}

	/**
	 * @param ActiveQuery $query
	 */
	public static function publicScope($query)
	{
		$query->andWhere("visibility_id = 'public'");
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
	public function getOriginalImage()
	{
		return $this->hasOne(Image::className(), ['id' => 'original_image_id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getSmallImage()
	{
		return $this->hasOne(Image::className(), ['id' => 'small_image_id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getMediumImage()
	{
		return $this->hasOne(Image::className(), ['id' => 'medium_image_id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getThumbnailImage()
	{
		return $this->hasOne(Image::className(), ['id' => 'thumbnail_image_id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getBlurredSmallImage()
	{
		return $this->hasOne(Image::className(), ['id' => 'blurred_small_image_id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getBlurredMediumImage()
	{
		return $this->hasOne(Image::className(), ['id' => 'blurred_medium_image_id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getBlurredThumbnailImage()
	{
		return $this->hasOne(Image::className(), ['id' => 'blurred_thumbnail_image_id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getVisibility()
	{
		return $this->hasOne(Visibility::className(), ['id' => 'visibility_id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getVehicleCountryCode()
	{
		return $this->hasOne(VehicleCountry::className(), ['code' => 'vehicle_country_code']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getAction()
	{
		return $this->hasOne(Action::className(), ['id' => 'action_id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getIncident()
	{
		return $this->hasOne(Incident::className(), ['id' => 'incident_id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getCitation()
	{
		return $this->hasOne(Citation::className(), ['id' => 'citation_id']);
	}

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function getCampaign()
	{
		return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
	}

    /**
     * @return string The current LatLng values separated with a comma (for immediate use in google)
     */
    public function getLatLng() {
		return $this->loc_lat . ',' . $this->loc_lng;
    }

    /**
     * @return string The orginal LatLng values separated with a comma (for immediate use in google)
     */
    public function getOrgLatLng() {
		return $this->org_loc_lat . ',' . $this->org_loc_lng;
    }

	/**
	 * If the review is not yet done, the pictures are emptied
	 */
	public function afterFind()
	{
		parent::afterFind();

		if (!
			(
			$this->visibility_id == 'public' ||
			\Yii::$app->user->checkAccess('isObjectOwner', array('model' => $this)) ||
			\Yii::$app->user->checkAccess('moderator')
			)
		) {
			$this->original_image_id = null;
			$this->small_image_id = null;
			$this->medium_image_id = null;
			$this->thumbnail_image_id = null;
			$this->blurred_small_image_id = null;
			$this->blurred_medium_image_id = null;
			$this->blurred_thumbnail_image_id = null;
		}
	}

}
