<?php

namespace frontend\models;

use Yii;
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
     * @var Date Override the taken date
     */
    public $taken_override;

    /**
     * @var string The dataurl of the image (used in create for direct image upload)
     */
    public $image_dataurl;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%picture}}';
    }
    
    /**
     * @inheritdoc
     */
    public function formName()
    {
        if ($this->scenario == 'defval') {
            // If we are in the defval scenario we must rename the form so that it can be used in parallel to the actual pictures; quite a hack but who cares....
            return parent::formName().'__DEFVAL';
        } else
        {
            return parent::formName();
        }
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
        // If no better coordinates exists set to 0,0 (nobody live there except for 'Ace Lock Service Inc' :=)
        $this->org_loc_lat = $this->loc_lat = 0;
        $this->org_loc_lng = $this->loc_lng = 0;
    }
        
    /**
     * Copy the overriding default values of some attributes - but only if they do not have the default empty content
     * @param Picture $defaultsvalues Default values which will override the existing values if given
     */
    public function copyDefaults($defaultvalues) {
        if ($defaultvalues->action_id <> -1) {
            $this->action_id = $defaultvalues->action_id;
        }

        if ($defaultvalues->campaign_id <> '') {
            $this->campaign_id = $defaultvalues->campaign_id;
        }

        if ($defaultvalues->citation_id <> '') {
            $this->citation_id = $defaultvalues->citation_id;
        }
        if ($defaultvalues->citation_affix <> '') {
            $this->citation_affix = $defaultvalues->citation_affix;
        }

        if ($defaultvalues->description <> '') {
            $this->description = $defaultvalues->description;
        }

        if ($defaultvalues->incident_id <> -1) {
            $this->incident_id = $defaultvalues->incident_id;
        }

        if ($defaultvalues->loc_formatted_addr <> '') {
            $this->loc_formatted_addr = $defaultvalues->loc_formatted_addr;
        }

        if ($defaultvalues->loc_lat <> 0 && $defaultvalues->loc_lng <> 0) {
            // Override geocoords only if not already set!
            if ($this->loc_lat == 0 && $this->loc_lng == 0) {
                $this->loc_lat = $defaultvalues->loc_lat;
                $this->loc_lng = $defaultvalues->loc_lng;
            }
        }

        if ($defaultvalues->name <> '') {
            $this->name = $defaultvalues->name;
        }

        if ($defaultvalues->vehicle_country_code <> '?') {
            $this->vehicle_country_code = $defaultvalues->vehicle_country_code;
        }

        if ($defaultvalues->vehicle_reg_plate <> '') {
            $this->vehicle_reg_plate = $defaultvalues->vehicle_reg_plate ;
        }

        if ($defaultvalues->visibility_id <> 'private') {
            $this->visibility_id = $defaultvalues->visibility_id ;
        }
        
        if ($defaultvalues->taken_override <> '') {
            $this->taken = $defaultvalues->taken_override;
        }
    }

    /**
     * @inheritdoc
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
                'value' => new \yii\db\Expression ('NOW() at time zone \'UTC\''),
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
     * Validator to check if taken is correctly set
     */
    public function validateTakenDate($attribute, $params)
    {
        if ($this->taken=='1970-01-01 00:00:00' && empty($this->taken_override))
            $this->addError('taken_override', "Sie müssen das Datum des Vorfalls setzen.");
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
        } else if ($this->scenario != 'defval' && $this->visibility_id == 'private' && \Yii::$app->user->can('anonymous')) {
            // Request to approval
            $this->visibility_id = 'public_approval_pending';
            
            $this->addError('visibility_id', 'Standardmäßig vermuten wir, dass Sie Bilder veröffentlichen wollen und haben daher in dem Feld Sichtbarkeit die Veröffentlichung beantragt. Sie müssen hierzu einfach noch einmal speichern. Sie können das aber auch ändern und die Veröffentlichung stattdessen explizit blocken.');
        }
        
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        // It is utmost important that only attributes which a safe to be mass assigned are listed here!
        // owner_id and the whole image_ids certainly should not be changed by the user!
        return [
            ['citation_id', 'default', 'value' => NULL],
            ['selected', 'default', 'value' => false],
            ['deleted', 'default', 'value' => false],
            ['image_dataurl', 'string', 'on' => self::SCENARIO_DEFAULT,],
            [['clip_x', 'clip_y', 'clip_size', 'visibility_id'], 'required', 'on' => self::SCENARIO_DEFAULT],
            [['clip_x', 'clip_y', 'clip_size', 'action_id', 'incident_id', 'citation_id', ], 'integer', 'on' => self::SCENARIO_DEFAULT],
            [['clip_x', 'clip_y', 'clip_size', 'action_id', 'incident_id', 'citation_id', ], 'filter', 'filter' => 'intval', 'skipOnEmpty' => true, 'on' => self::SCENARIO_DEFAULT],
            ['taken_override', 'date'],
            ['taken_override', 'validateTakenDate', 'skipOnEmpty' => false, 'on' => self::SCENARIO_DEFAULT],

            [['name', 'description', 'loc_formatted_addr', 'visibility_id', 'vehicle_country_code', 'vehicle_reg_plate', 'citation_affix',], 'string'],

            // Only if the pic is new you can set these attributes
            [['org_loc_lat', 'org_loc_lng',], 'double', 'when' => function ($model) {return $model->isNewRecord;}, 'on' => self::SCENARIO_DEFAULT],
            [['taken', ], 'date', 'format' => 'yyyy-MM-dd HH:mm:ss', 'when' => function ($model) {return $model->isNewRecord;}, 'on' => self::SCENARIO_DEFAULT],
                
            [['loc_lat', 'loc_lng',], 'double'],
            ['visibility_id',  'validateVisibilityConsistency', ],
            [['loc_lat', 'loc_lng'], 'validateLocationConsistency', 'on' => self::SCENARIO_DEFAULT],
            [['vehicle_reg_plate'], 'filter', 'filter' => 'mb_strtoupper', 'skipOnEmpty' => true],
            [['vehicle_reg_plate'], 'match', 'not'=>true, 'pattern' => '/[?]/', 'skipOnEmpty' => true, ],
            ['vehicle_country_code', 'validateVehiclePlateConsistency', 'skipOnEmpty' => false, 'on' => self::SCENARIO_DEFAULT,],
            // Only trusted users currently may assign to a campaign
            ['campaign_id', 'default', 'value' => NULL, 'when' => function ($model) {return Yii::$app->user->can('trusted');}],
            ['campaign_id', 'integer', 'when' => function ($model) {return Yii::$app->user->can('trusted');}],
            ['campaign_id', 'filter', 'filter' => 'intval', 'skipOnEmpty' => true, 'when' => function ($model) {return Yii::$app->user->can('trusted');}],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios['upload'] = $scenarios[self::SCENARIO_DEFAULT];
        $scenarios['defval'] = $scenarios[self::SCENARIO_DEFAULT];
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
            'taken_override' => 'Korrektur Vorfallsdatum',
            'org_loc' => 'Originale Aufnahmeposition',
            'org_loc_lat' => 'Originale Geo-Position (Breite)',
            'org_loc_lng' => 'Originale Geo-Position (Länge)',
            'loc' => 'Aufnahmeposition',
            'loc_lat' => 'Geo-Position (Breite)',
            'loc_lng' => 'Geo-Position (Länge)',
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
            'citation_affix' => 'Interner Zusatz',
            'action_id' => 'Maßnahme',
            'incident_id' => 'Vorfall',
            'citation_id' => 'Meldung',
            'campaign_id' => 'Kampagne',
            'created_ts' => 'Hochgeladen am (UTC)',
            'modified_ts' => 'Geändert am (UTC)',
            'deleted_ts' => 'Gelöscht am (UTC)',
            'selected' => 'Auswählen',
            'deleted' => 'Löschen',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (!empty($this->taken_override)) {
                $this->taken = $this->taken_override;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * @inheritdoc
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
        return $this->hasOne(\common\models\User::className(), ['id' => 'owner_id']);
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
     * The date when the picture has been uploaded is used to find out whether the picture/incident is legacy and has the right to be forgotten
     * @return boolean Is the picture older then a year?
     */
    public function isLegacy()
    {
        return date_create()->diff(date_create ($this->created_ts))->y >= 1;
    }

    /**
     * Fill the data from the binary input; best encapsule in transaction for atomic behavior
     * @param string $blob The binary content of the orignal image
     */
    public function fillFromBinary($blob) {
        $image = new Image;
        $rawdata = new Imagick();
        $rawdata->readimageblob($blob);
        $rawdata->setImageFormat( "jpeg" );
        $this->autoRotateImage($rawdata);
        $image->rawdata = bin2hex($rawdata->getimageblob());
        $image->save(false);
        $this->original_image_id = $image->id;

        $rawdata = new Imagick();
        $rawdata->readimageblob($blob);
        $rawdata->setImageFormat( "jpeg" );
        $this->autoRotateImage($rawdata);
        $rawdata->profileimage('*', NULL); // Remove profile information
        $rawdata->scaleimage(0, 100);
        $image = new Image;
        $image->rawdata = bin2hex($rawdata->getimageblob());
        $image->save(false);
        $this->thumbnail_image_id = $image->id;

        $rawdata->blurimage(3, 3);
        $image = new Image;
        $image->rawdata = bin2hex($rawdata->getimageblob());
        $image->save(false);
        $this->blurred_thumbnail_image_id = $image->id;

        $rawdata = new Imagick();
        $rawdata->readimageblob($blob);
        $rawdata->setImageFormat( "jpeg" );
        $this->autoRotateImage($rawdata);
        $rawdata->profileimage('*', NULL); // Remove profile information
        $rawdata->scaleimage(0, 240);
        $image = new Image;
        $image->rawdata = bin2hex($rawdata->getimageblob());
        $image->save(false);
        $this->small_image_id = $image->id;

        $rawdata->blurimage(3, 3);
        $image = new Image;
        $image->rawdata = bin2hex($rawdata->getimageblob());
        $image->save(false);
        $this->blurred_small_image_id = $image->id;

        $rawdata = new Imagick();
        $rawdata->readimageblob($blob);
        $rawdata->setImageFormat( "jpeg" );
        $this->autoRotateImage($rawdata);
        $rawdata->profileimage('*', NULL); // Remove profile information
        $rawdata->scaleimage(0, 500);
        $image = new Image;
        $image->rawdata = bin2hex($rawdata->getimageblob());
        $image->save(false);
        $this->medium_image_id = $image->id;

        $rawdata->blurimage(5, 5);
        $image = new Image;
        $image->rawdata = bin2hex($rawdata->getimageblob());
        $image->save(false);
        $this->blurred_medium_image_id = $image->id;

    }

    /**
     * Fill the data from the file input; best encapsule in transaction for atomic behavior
     * @param string $filename The name of the file with the image
     * @param Picture $defaultsvalues Optional default values which will override the existing values if given
     */
    public function fillFromFile($filename, $defaultvalues=NULL) {
        $this->setDefaults();

        $props = exif_read_data($filename);
        if (isset($props['GPSLatitude']) && isset($props['GPSLatitudeRef']) && isset($props['GPSLongitude']) && isset($props['GPSLongitudeRef'])) {
            $this->org_loc_lat = $this->loc_lat = $this->getGPS($props['GPSLatitude'], $props['GPSLatitudeRef']);
            $this->org_loc_lng = $this->loc_lng = $this->getGPS($props['GPSLongitude'], $props['GPSLongitudeRef']);
        }

        if (isset($props['DateTimeOriginal'])) {
            list($date, $time) = explode(' ', $props['DateTimeOriginal']); // 2011:09:17 10:36:00'
            $date = str_replace(':', '-', $date);
            $this->taken = $date . ' ' . $time;
        } else 
        if (isset($props['DateTime'])) {
            list($date, $time) = explode(' ', $props['DateTime']); // 2011:09:17 10:36:00'
            $date = str_replace(':', '-', $date);
            $this->taken = $date . ' ' . $time;
        } else {
            $this->taken = '1970-01-01 00:00:00.0000';
            $this->description = 'FEHLER: KEIN GÜLTIGES AUFNAHMEDATUM!';
        }

        $image = new Image;
        $rawdata = new Imagick($filename);
        $this->autoRotateImage($rawdata);
        $rawdata->scaleimage(0, 800);
        $image->rawdata = bin2hex($rawdata->getimageblob());
        $image->save(false);
        $this->original_image_id = $image->id;

        $rawdata = new Imagick($filename);
        $this->autoRotateImage($rawdata);
        $rawdata->profileimage('*', NULL); // Remove profile information
        $rawdata->scaleimage(0, 100);
        $image = new Image;
        $image->rawdata = bin2hex($rawdata->getimageblob());
        $image->save(false);
        $this->thumbnail_image_id = $image->id;

        $rawdata->blurimage(3, 3);
        $image = new Image;
        $image->rawdata = bin2hex($rawdata->getimageblob());
        $image->save(false);
        $this->blurred_thumbnail_image_id = $image->id;

        $rawdata = new Imagick($filename);
        $this->autoRotateImage($rawdata);
        $rawdata->profileimage('*', NULL); // Remove profile information
        $rawdata->scaleimage(0, 240);
        $image = new Image;
        $image->rawdata = bin2hex($rawdata->getimageblob());
        $image->save(false);
        $this->small_image_id = $image->id;

        $rawdata->blurimage(3, 3);
        $image = new Image;
        $image->rawdata = bin2hex($rawdata->getimageblob());
        $image->save(false);
        $this->blurred_small_image_id = $image->id;

        $rawdata = new Imagick($filename);
        $this->autoRotateImage($rawdata);
        $rawdata->profileimage('*', NULL); // Remove profile information
        $rawdata->scaleimage(0, 500);
        $image = new Image;
        $image->rawdata = bin2hex($rawdata->getimageblob());
        $image->save(false);
        $this->medium_image_id = $image->id;

        $rawdata->blurimage(5, 5);
        $image = new Image;
        $image->rawdata = bin2hex($rawdata->getimageblob());
        $image->save(false);
        $this->blurred_medium_image_id = $image->id;
        
        if (isset($defaultvalues)) {
            $this->copyDefaults($defaultvalues);
        }
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
