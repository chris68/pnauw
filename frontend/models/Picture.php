<?php

namespace frontend\models;

use yii;
use yii\db\ActiveQuery;
use frontend\models\Image;
use Imagick;

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
     * @var boolean Has the picture been selected in a view grid/list?
     */
    public $selected;

	/**
     * @var boolean Has the picture been marked for deletion in a view grid/list?
     */
    public $deleted;

	/**
	 * {@inheritdoc}
	 */
	public static function tableName()
	{
		return '{{%picture}}';
	}
	
	/**
	 * Set the default values of some attributes
	 */
	public function setDefaults() {
		$this->visibility_id = 'private';
		$this->vehicle_country_code = 'D';
		$this->incident_id = -1;
		$this->action_id = -1;
		$this->clip_x = 50;
		$this->clip_y = 50;
		$this->clip_size = 25;
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
				'class' => 'common\behaviors\EnsureOwnershipWithModeration',
				'ownerAttribute' => 'owner_id',
				'ensureOnFind' => false,
			],
		];
	}

	/**
	 * Validator to check if location makes sense 
	 */
	public function validateLocationConsistency($attribute, $params)
	{
		if ($this->loc_lat == 0 && $this->loc_lng == 0) {
			$this->addError('loc', 'Die Aufnahmeposition des Bildes muss angegeben werden.');
		} elseif (!($this->loc_lng > -14 && $this->loc_lng < 38 && $this->loc_lat > 32 && $this->loc_lat < 65)) {
			$this->addError('loc', 'Die Aufnahmeposition des Bildes muss im Kernbereich von Europa sein.');
		}
			
	}

	/**
	 * Validator to check if country is filled if reg_plate is filled 
	 */
	public function validateVehiclePlateConsistency($attribute, $params)
	{
		if (!empty($this->vehicle_reg_plate) and $this->vehicle_country_code=='?')
			$this->addError('vehicle_country_code', 'Das Land des eingetragenen Kfz-Kennzeichens muss angegeben werden.');
	}

	/**
	 * Validator to check if the user may set the visibility to public
	 */
	public function validateVisibilityConsistency($attribute, $params)
	{
		if ($this->visibility_id == 'public' && !\Yii::$app->user->can('trusted')) {
			if (!$this->getIsNewRecord()) {
				/* @var $old frontend\models\Picture */
				$old = Picture::findOne($this->id);
				
				// Check whether it was already public before AND the user did not change any relevant information!
				if ($old->visibility_id == 'public') {
					if ($old->name == $this->name && $old->description == $this->description) {
						// Ok. Already reviewed and no relevant changes!
						return;
					}
				}
			}
			
			// Request to approval
			$this->visibility_id = 'public_approval_pending';
			
			$this->addError('visibility_id', 'Sie dürfen mit ihren Rechten leider keine Bilder oder Texte direkt veröffentlichen, sondern müssen die Freigabe anfordern. Die Sichtbarkeit wurde entsprechend angepasst. Bitte speichern Sie nun erneut.');
		} else if ($this->visibility_id != 'public_approval_pending' && \Yii::$app->user->can('anonymous')) {
			// Request to approval
			$this->visibility_id = 'public_approval_pending';
			
			$this->addError('visibility_id', 'Sie wollen das Bild ja bestimmt auch veröffentlichen. Die Sichtbarkeit wurde entsprechend angepasst. Bitte speichern Sie nun erneut.');
		}
		
	}

	/**
	 * {@inheritdoc}
	 */
	public function rules()
	{
		// It is utmost important that only attributes which a safe to be mass assigned are listed here!
		// owner_id and the whole image_ids certainly should not be changed by the user!
		$rules = [
			['citation_id', 'default', 'value' => NULL],
			['selected', 'default', 'value' => false],
			['deleted', 'default', 'value' => false],
			[['clip_x', 'clip_y', 'clip_size', 'visibility_id'], 'required'],
			[['clip_x', 'clip_y', 'clip_size', 'action_id', 'incident_id', 'citation_id', ], 'integer'],
			[['name', 'description', 'loc_path', 'loc_formatted_addr', 'visibility_id', 'vehicle_country_code', 'vehicle_reg_plate', 'citation_affix',], 'string'],
			[['loc_lat', 'loc_lng',], 'double'],
			['visibility_id',  'validateVisibilityConsistency', ],
			[['loc_lat', 'loc_lng'], 'validateLocationConsistency', 'on' => self::SCENARIO_DEFAULT],
			['vehicle_reg_plate', \common\validators\ConvertToUppercase::className()],
			['vehicle_country_code', 'validateVehiclePlateConsistency', 'skipOnEmpty' => false,],
		];
		if (Yii::$app->user->can('trusted')) {
			// Only trusted users currently may assign to a campaign
			$rules = array_merge($rules,
			[
				['campaign_id', 'default', 'value' => NULL],
				['campaign_id', 'integer'],
			]);
		};
		return $rules;
	}

	/**
	 * {@inheritdoc}
	 */
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios['create'] = $scenarios[self::SCENARIO_DEFAULT];
		return $scenarios;
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
			'org_loc' => 'Originale Aufnahmeposition',
			'org_loc_lat' => 'Originale Geo-Position (Breite)',
			'org_loc_lng' => 'Originale Geo-Position (Länge)',
			'loc' => 'Aufnahmeposition',
			'loc_lat' => 'Geo-Position (Breite)',
			'loc_lng' => 'Geo-Position (Länge)',
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
			'selected' => 'Auswählen',
			'deleted' => 'Löschen',
		];
	}

	/**
	 * {@inheritdoc}
	 */
    public static function find()
    {
        return new PictureQuery(get_called_class());
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
	 * @todo: Use a view and a separate class PicturePublicAccess instead!!!
	 * If the review is not yet done, the pictures and some texts are emptied
	 */
	public function afterFind()
	{
		parent::afterFind();

		if (!
			(
			$this->visibility_id == 'public' ||
			\Yii::$app->user->can('isObjectOwner', array('model' => $this)) ||
			\Yii::$app->user->can('moderator')
			)
		) {
			$this->name = empty($this->name)?'':'[Der Titel wurde leider noch nicht von einem Moderator freigebeben]';
			$this->description = empty($this->description)?'':'[Die Beschreibung leider noch nicht von Moderator freigebeben]';
			$this->original_image_id = null;
			$this->small_image_id = null;
			$this->medium_image_id = null;
			$this->thumbnail_image_id = null;
			$this->blurred_small_image_id = null;
			$this->blurred_medium_image_id = null;
			$this->blurred_thumbnail_image_id = null;
		}
	}

	/**
	 * Fill the data from the file input and saves the data; best encapsule in transaction for atomic behavior
	 * @param file $file The image
	 */
	public function fillFromFile($file) {
		$this->setDefaults();

		$props = exif_read_data($file->tempName);
		if (isset($props['GPSLatitude']) && isset($props['GPSLatitudeRef']) && isset($props['GPSLongitude']) && isset($props['GPSLongitudeRef'])) {
			$this->org_loc_lat = $this->loc_lat = $this->getGPS($props['GPSLatitude'], $props['GPSLatitudeRef']);
			$this->org_loc_lng = $this->loc_lng = $this->getGPS($props['GPSLongitude'], $props['GPSLongitudeRef']);
		} else {
			// If no coordinates exists set to 0,0 (nobody live there except for 'Ace Lock Service Inc' :=)
			$this->org_loc_lat = $this->loc_lat = 0;  
			$this->org_loc_lng = $this->loc_lng = 0; 
		}

		if (isset($props['DateTimeOriginal'])) {
			list($date, $time) = explode(' ', $props['DateTimeOriginal']); // 2011:09:17 10:36:00'
			$date = str_replace(':', '-', $date);
			$this->taken = $date . ' ' . $time;
		} else {
			$this->taken = '1970-01-01 00:00:00.0000';
			$this->description = 'FEHLER: KEIN GÜLTIGES AUFNAHMEDATUM!';
		}

		$image = new Image;
		$rawdata = new Imagick($file->tempName);
		$this->autoRotateImage($rawdata);
		$image->rawdata = bin2hex($rawdata->getimageblob());
		$image->save(false);
		$this->original_image_id = $image->id;

		$rawdata = new Imagick($file->tempName);
		$this->autoRotateImage($rawdata);
		$rawdata->profileimage('*', NULL); // Remove profile information
		$rawdata->scaleimage(75, 100);
		$image = new Image;
		$image->rawdata = bin2hex($rawdata->getimageblob());
		$image->save(false);
		$this->thumbnail_image_id = $image->id;

		$rawdata->blurimage(3, 2);
		$image = new Image;
		$image->rawdata = bin2hex($rawdata->getimageblob());
		$image->save(false);
		$this->blurred_thumbnail_image_id = $image->id;

		$rawdata = new Imagick($file->tempName);
		$this->autoRotateImage($rawdata);
		$rawdata->profileimage('*', NULL); // Remove profile information
		$rawdata->scaleimage(180, 240);
		$image = new Image;
		$image->rawdata = bin2hex($rawdata->getimageblob());
		$image->save(false);
		$this->small_image_id = $image->id;

		$rawdata->blurimage(3, 2);
		$image = new Image;
		$image->rawdata = bin2hex($rawdata->getimageblob());
		$image->save(false);
		$this->blurred_small_image_id = $image->id;

		$rawdata = new Imagick($file->tempName);
		$this->autoRotateImage($rawdata);
		$rawdata->profileimage('*', NULL); // Remove profile information
		$rawdata->scaleimage(375, 500);
		$image = new Image;
		$image->rawdata = bin2hex($rawdata->getimageblob());
		$image->save(false);
		$this->medium_image_id = $image->id;

		$rawdata->blurimage(5, 3);
		$image = new Image;
		$image->rawdata = bin2hex($rawdata->getimageblob());
		$image->save(false);
		$this->blurred_medium_image_id = $image->id;

		$this->save(false);
	}

	/**
	 * Resolve the rationale in the EXIF style GPS coordinate
	 * @param string $coordPart Exif Degree/Minute/Second
	 * @return float The respective float value 
	 * @link http://stackoverflow.com/questions/2526304/php-extract-gps-exif-data/2526412#2526412 Source
	 */
	private function gps2Num($coordPart)
	{
		$parts = explode('/', $coordPart);

		if (count($parts) <= 0)
			return 0;

		if (count($parts) == 1)
			return $parts[0];

		return floatval($parts[0]) / floatval($parts[1]);
	}

	/**
	 * Get the float representation of EXIF style GPS coordinates
	 * @param string $exifCoord Exif Longitude/Latitude
	 * @param array $hemi Exif LongitudeRef/LatitudeRef
	 * @return float The respective float value 
	 * @link http://stackoverflow.com/questions/2526304/php-extract-gps-exif-data/2526412#2526412 Source
	 */
	private function getGps($exifCoord, $hemi)
	{
		$degrees = count($exifCoord) > 0 ? $this->gps2Num($exifCoord[0]) : 0;
		$minutes = count($exifCoord) > 1 ? $this->gps2Num($exifCoord[1]) : 0;
		$seconds = count($exifCoord) > 2 ? $this->gps2Num($exifCoord[2]) : 0;

		$flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

		return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
	}


	private function autoRotateImage($image)
	{
		$orientation = $image->getImageOrientation();

		switch ($orientation) {
			case imagick::ORIENTATION_BOTTOMRIGHT:
				$image->rotateimage("#000", 180); // rotate 180 degrees
				break;

			case imagick::ORIENTATION_RIGHTTOP:
				$image->rotateimage("#000", 90); // rotate 90 degrees CW
				break;

			case imagick::ORIENTATION_LEFTBOTTOM:
				$image->rotateimage("#000", -90); // rotate 90 degrees CCW
				break;
		}

		// Now that it's auto-rotated, make sure the EXIF data is correct in case the EXIF gets saved with the image!
		$image->setImageOrientation(imagick::ORIENTATION_TOPLEFT);
	}
}
