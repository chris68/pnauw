<?php
namespace frontend\models;

use common\models\User;
use Yii;

/**
 * User Appdata form
 */
class UserappdataForm extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reg_codes'],'string'],
            [['reg_codes'], 'filter', 'filter' => 'mb_strtoupper', 'skipOnEmpty' => true],
            [['reg_codes'], 'match', 'pattern' => '/^([A-ZÖÄÜ])+(,([A-ZÖÄÜ])+)*$/i', 'skipOnEmpty' => true, 'message'=>'Sie müssen eine mit Komma separierte Liste von Unterscheidungskennzeichen eingeben'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'reg_codes' => 'Unterscheidungszeichen',
        ];
    }
    

}
