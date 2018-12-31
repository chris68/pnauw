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
 * @property string $created_ts
 * @property string $modified_ts
 * @property string $released_ts
 * @property string $deleted_ts
 *
 * @property User $owner
 */
class Flyer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_flyer';
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
                'class' => 'common\behaviors\EnsureOwnership',
                'ownerAttribute' => 'owner_id',
                'ensureOnFind' => false,
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'description', 'flyertext', 'secret', ], 'required'],
            [['name', 'description', 'flyertext', 'secret', ], 'string'],
            [['secret', ], 'unique'],
            [['running_from', 'running_until'], 'default', 'value' => NULL],
            [['running_from', 'running_until'], 'date'],
            [['loc_filter',], 'default', 'value' => NULL],
            [['loc_filter'], 'string'],
            [['loc_filter'], 'match', 'pattern' => '/^[^*+?{}]*$/'],
        ];
    }

    /**
     * @inheritdoc
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
            'loc_filter' => 'Ortsfilter',
            'created_ts' => 'Angelegt am (UTC)',
            'modified_ts' => 'Verändert am (UTC)',
            'released_ts' => 'Freigegeben am (UTC)',
            'deleted_ts' => 'Gelöscht am (UTC)',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function find()
    {
        return new FlyerQuery(get_called_class());
    }
    
    /**
     * @return \yii\db\ActiveRelation
     */
    public function getOwner()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'owner_id']);
    }
}