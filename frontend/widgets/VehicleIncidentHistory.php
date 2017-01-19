<?php

namespace frontend\widgets;
use frontend\models\Picture;
use frontend\controllers\PictureController;
use yii\helpers\Url;
use yii\helpers\Html;

/**
 * Display the history of a vehicle
 */
class VehicleIncidentHistory extends \yii\base\Widget
{
 
    /**
     *
     * @var \frontend\models\Picture The respective picture
     */
    public $picture;
 
    /**
     * @var array the HTML attributes for the container tag of this widget.
     */
    public $options = [];
    
    public function init()
    {
        parent::init();

        if (!empty($this->picture->vehicle_reg_plate) && $this->picture->vehicle_reg_plate <> '-') {
            $count = Picture::find()->ownerScope()->andWhere(['vehicle_reg_plate' => $this->picture->vehicle_reg_plate])->count();

            if ($count > 3) {
                $content = 'Bereits <b style="color:red">'.$count.' Vorfälle</b>';
            }
            elseif ($count > 1) {
                $content = 'Bereits <b>'.$count.' Vorfälle</b> ';
            } else {
                $content = 'Keine weiteren Vorfälle';
            }
            $content = $content.' bei <a target = "_blank" href="'.Url::to(PictureController::urlVehicleRegPlate('manage',$this->picture->vehicle_reg_plate)).'">'.Html::encode($this->picture->vehicle_reg_plate).'</a>';

            echo \yii\helpers\Html::tag('p',$content,$this->options);
        }
    }
 
};

?>
