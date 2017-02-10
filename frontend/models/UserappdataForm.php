<?php
namespace frontend\models;

use common\models\User;
use Yii;
use paulzi\jsonBehavior\JsonValidator;

/**
 * User Appdata form
 */
class UserappdataForm extends User
{
   /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        // Currently many users come from the Karlsruhe area; therefore, we default with helpful values for those guys. Baden rulez!
        $this->setAppdata__reg_codes('KA,PF,GER,SÜW,RP,LD,HD,RA,OG,S');
        $this->setAppdata__geo_accuracy('15');
    }

     /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appdata__reg_codes'],'string'],
            [['appdata__reg_codes'], 'filter', 'filter' => 'mb_strtoupper', 'skipOnEmpty' => true],
            [['appdata__reg_codes'], 'match', 'pattern' => '/^([A-ZÖÄÜ])+(,([A-ZÖÄÜ])+)*$/i', 'skipOnEmpty' => true, 'message'=>'Sie müssen eine mit Komma separierte Liste von Unterscheidungskennzeichen eingeben'],
            [['appdata__geo_accuracy'],'integer', 'min'=>'1', 'max'=>'800000'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'appdata__reg_codes' => 'Unterscheidungszeichen',
            'appdata__geo_accuracy' => 'Schwelle Positionsgenauigkeit',
        ];
    }
    
    public function getAppdata__reg_codes() {
        return $this->appdata['reg_codes'];
    }
    public function setAppdata__reg_codes($value) {
        $this->appdata['reg_codes'] = $value;
    }

    public function getAppdata__geo_accuracy() {
        return $this->appdata['geo_accuracy'];
    }
    public function setAppdata__geo_accuracy($value) {
        $this->appdata['geo_accuracy'] = $value;
    }
}
