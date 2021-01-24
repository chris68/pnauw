<?php

namespace frontend\models;

/**
 * This is the model class for table "tbl_citation".
 *
 * @property integer $id
 * @property integer $owner_id
 * @property string $name
 * @property string $type Either 'citation','complaint','empty'
 * @property string $description
 * @property string $recipient_email
 * @property string $recipient_address
 * @property string $printout_url
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
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_citation';
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
            [['name', 'description', 'type', ], 'required'],
            [['name', 'description', 'type', 'recipient_email', 'recipient_address', 'printout_url'], 'string']
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
            'description' => 'Zusatzinformationen',
            'recipient_email' => 'Email des Empfängers',
            'recipient_address' => 'Postadresse des Empfängers',
            'printout_url' => 'Freigabe-URL des Ausdrucks',
            'type' => 'Typ/Vorlage',
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
        return new CitationQuery(get_called_class());
    }
    
    /**
     * @return \yii\db\ActiveRelation
     */
    public function getPictures()
    {
        $return = $this->hasMany(Picture::className(), ['citation_id' => 'id']);
        if ($this->type == 'citation') {
           $return = $return->orderBy(['vehicle_country_code' => SORT_ASC ,'vehicle_reg_plate'  => SORT_ASC, 'taken' => SORT_ASC, ]);
        } elseif ($this->type == 'complaint') {
           $return = $return->orderBy(['(select regexp_matches(loc_formatted_addr , \'[0-9]{5}\'))[1]' => SORT_ASC,'loc_formatted_addr' => SORT_ASC , 'taken' => SORT_ASC, ]);
        } elseif ($this->type == 'empty') {
           $return = $return->orderBy(['(select regexp_matches(loc_formatted_addr , \'[0-9]{5}\'))[1]' => SORT_ASC,'loc_formatted_addr' => SORT_ASC , 'taken' => SORT_ASC, ]);
        }
        return $return;
    }

    /**
     * @return \yii\db\ActiveRelation
     */
    public function getOwner()
    {
        return $this->hasOne(\common\models\User::className(), ['id' => 'owner_id']);
    }
    
    /**
     * Input for a standard dropdown list for all items
     * @return array 
     */
    public static function dropDownList()
    {
        return ['' => '(nicht gesetzt)'] + \yii\helpers\ArrayHelper::map(self::find()->dropdownScope()->orderBy('modified_ts desc')->all(),'id','name');
    }
    
    /**
     * Input for a standard dropdown list for all items (for usage in search)
     * @return array
     */
    public static function dropDownListSearch()
    {
        return ['#' => '(nicht gesetzt)'] + \yii\helpers\ArrayHelper::map(self::find()->dropdownScope()->orderBy('modified_ts desc')->all(),'id','name');
    }

    /**
     * Input for a standard dropdown list for the type of a citation
     * @return array 
     */
    public static function dropDownListForType()
    {
        return ['' => '(nicht gesetzt)', 'citation' => 'rechtsverbindliche Anzeige (Gehwegparken)', 'complaint' => 'unverbindliche Beschwerde (Gehwegparken)', 'empty' => 'Blankovorlage',];
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
