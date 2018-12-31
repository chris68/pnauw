<?php

namespace frontend\models;

/**
 * This is the model class for table "tbl_vehicle_country".
 *
 * @property string $code
 * @property string $sortkey
 * @property string $category
 * @property string $name
 * @property string $description
 * @property string $created_ts
 * @property string $modified_ts
 * @property string $deleted_ts
 *
 * @property Picture[] $pictures
 */
class VehicleCountry extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_vehicle_country';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'sortkey', 'category', 'name', 'description'], 'required'],
            [['code', 'sortkey', 'category', 'name', 'description', 'created_ts', 'modified_ts', 'deleted_ts'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'sortkey' => 'Sortkey',
            'category' => 'Category',
            'name' => 'Name',
            'description' => 'Description',
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
        return $this->hasMany(Picture::className(), ['vehicle_country_code' => 'code']);
    }
    
    /**
     * Input for a standard dropdown list for all items
     * @return array 
     */
    public static function dropDownList()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->orderBy('sortkey')->all(),'code','name', 'category');
    }
    
}
