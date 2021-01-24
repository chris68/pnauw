<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Citation */
/* @var $printParameters frontend\models\PicturePrintForm */

use yii\helpers\Html;
use frontend\models\Citation;
use frontend\models\PicturePrintForm;

?>

        <table class="table">
            <thead>
              <tr>
                <th>ID</th>
                <th>Maßnahme</th>
                <th>Zeitpunkt</th>
                <th>Ort</th>
                <th>Vorfall</th>
                <th><?=($model->type == 'citation')?'KFZ':''?></th>
              </tr>
            </thead>
            <tbody>
    <?php
        /* var $pic frontend\models\Picture */
        foreach ($model->getPictures()->all() as $pic) {
    ?>
                <tr>
                  <td><?=$pic->id?></td>
                  <td><?=$pic->action->name?></td>
                  <td><?=($model->type == 'citation')?$pic->taken:date_format(date_create($pic->taken),'d.m.Y')?></td>
                  <td><?=$pic->loc_formatted_addr?></td>
                  <td><?=$pic->incident->name?></td>
                  <td><?=$model->type == 'citation' && $printParameters->visibility=='unchanged'?$pic->vehicle_reg_plate:''?>
                </tr>
        
    <?php
        }
    ?>
            </tbody>
        </table>                
