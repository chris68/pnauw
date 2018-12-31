<?php

namespace frontend\models;

/**
 * This is the model class for table "tbl_severity".
 *
 * @property integer $level
 * @property string $name
 * @property string $description
 * @property string $created_ts
 * @property string $modified_ts
 * @property string $deleted_ts
 *
 * @property Incident[] $incidents
 */
class Severity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tbl_severity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['level', 'name', 'description'], 'required'],
            [['level'], 'integer'],
            [['name', 'description', 'created_ts', 'modified_ts', 'deleted_ts'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'level' => 'Level',
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
    public function getIncidents()
    {
        return $this->hasMany(Incident::className(), ['severity' => 'level']);
    }

    /**
     * Input for a standard dropdown list for all items
     * @return array 
     */
    public static function dropDownList()
    {
        return \yii\helpers\ArrayHelper::map(self::find()->orderBy('level')->all(),'level','name');
    }
    
}
