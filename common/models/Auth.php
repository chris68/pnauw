<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%auth}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $source
 * @property string $source_id
 * @property string $source_name
 *
 * @property User $user
 */
class Auth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'EnsureOwnership' => [
                'class' => 'common\behaviors\EnsureOwnership',
                'ownerAttribute' => 'user_id',
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
            [['user_id', 'source', 'source_id', 'source_name'], 'required'],
            [['user_id'], 'integer'],
            [['source', 'source_id', 'source_name'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'source' => 'Source',
            'source_id' => 'Source ID',
            'source_name' => 'Source Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
