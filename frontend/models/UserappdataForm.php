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
     * @inheritdoc
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

    public function getAppdata__reg_codes_autoupdate() {
        return $this->appdata['reg_codes_autoupdate'];
    }
    public function setAppdata__reg_codes_autoupdate($value) {
        $this->appdata['reg_codes_autoupdate'] = $value;
    }

    public function getAppdata__reg_plate_purge_latency() {
        return $this->appdata['reg_plate_purge_latency'];
    }
    public function setAppdata__reg_plate_purge_latency($value) {
        $this->appdata['reg_plate_purge_latency'] = $value;
    }

    public function getAppdata__geo_accuracy() {
        return $this->appdata['geo_accuracy'];
    }
    public function setAppdata__geo_accuracy($value) {
        $this->appdata['geo_accuracy'] = $value;
    }
    
    public function getAppdata__geo_timeout() {
        return $this->appdata['geo_timeout'];
    }
    public function setAppdata__geo_timeout($value) {
        $this->appdata['geo_timeout'] = $value;
    }
    
    public function getAppdata__map_zoom() {
        return $this->appdata['map_zoom'];
    }
    public function setAppdata__map_zoom($value) {
        $this->appdata['map_zoom'] = $value;
    }
    
    public function getAppdata__citation_visibility() {
        return $this->appdata['citation_visibility'];
    }
    public function setAppdata__citation_visibility($value) {
        $this->appdata['citation_visibility'] = $value;
    }
}
