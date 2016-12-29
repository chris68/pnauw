<?php

namespace frontend\models;

/**
 * This is the model class for table "tbl_flyer".
 *
 * @property integer $id
 * @property integer $owner_id
 * @property string $name
 * @property string $description
 * @property string $flyertext
 * @property string $secret
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
class Flyer extends \yii\db\ActiveRecord
{
    /**
     * Quick hack to support the attribute without model changes
     */
    public $availability_id = 'private';
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_flyer';
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
        if ((strpos($this->visibility_id,'public') !== false) && !\Yii::$app->user->can('trusted')) {
            $this->addError('visibility_id', 'Sie dürfen als noch nicht vertrauenswürdiger Nutzer derzeit leider generell noch keine Kampagnen veröffentlichen!');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'flyertext', 'secret', 'visibility_id', 'availability_id', 'running_from', 'running_until'], 'required'],
            [['name', 'description', 'flyertext', 'secret', 'visibility_id', 'availability_id', /*'loc_path',*/ ], 'string'],
            [['secret', ], 'unique'],
            ['visibility_id',  'validateVisibilityConsistency', ],
            [['running_from', 'running_until'], 'default', 'value' => NULL],
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
            'flyertext' => 'Zetteltext',
            'secret' => 'Zettelzugangscode',
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
    public static function find()
    {
        return new FlyerQuery(get_called_class());
    }
    
    /**
     * @return \yii\db\ActiveRelation
     */
    public function getPictures()
    {
        return $this->hasMany(Picture::className(), ['flyer_id' => 'id']);
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

}
