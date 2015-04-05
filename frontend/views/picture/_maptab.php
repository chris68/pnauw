<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */
/* @var $form yii\bootstrap\ActiveForm */

use \yii\helpers\Html;
?>

<div class="row">
    <div class="col-lg-4">
        <div class ="form-group">
        <?php echo Html::label('Kartensuche (via Google Maps)','picture-map-search-address'); ?>
        <input type="text" id="picture-map-search-address" class="form-control" autocomplete="off" value="<?=$model->loc_formatted_addr?>" placeholder="Kartensuche">
        </div>
        <div class ="form-group">
        <?php echo Html::label('Nächstliegende Adresse (ermittelt via Google Maps)','picture-map-nearest-address-google'); ?>
        <p id="picture-map-nearest-address-google"></p>
        </div>
        <div class ="form-group">
        <?php echo Html::label('Nächstliegende Adresse (ermittelt via Mapquest)','picture-map-nearest-address-mapquest'); ?>
        <p id="picture-map-nearest-address-mapquest"></p>
        </div>
        <?= $form->field($model,'loc_formatted_addr')->textInput(['id'=>'picture-map-loc-formatted-addr', ]) ?>
        <!-- Hidden fields are not reset upon a form reset; therefore, we need to use normal fields which we hide -->
        <?= Html::activeInput('text', $model,'loc_lat', ['id'=>'picture-map-loc-lat', 'style' => 'display:none', ]) ?>
        <?= Html::activeInput('text', $model,'loc_lng',['id'=>'picture-map-loc-lng', 'style' => 'display:none', ]) ?>
        <?= Html::activeHiddenInput($model,'org_loc_lat', ['id'=>'picture-map-loc-lat-org', ]) ?>
        <?= Html::activeHiddenInput($model,'org_loc_lng',['id'=>'picture-map-loc-lng-org', ]) ?>
    </div>
    <div class="col-lg-4">
        <!-- The Google maps canvas needs absolute coordinates -->
        <div style="width: 300px; height: 300px;" id="picture-map-canvas"></div>
        
    </div>
    <div class="col-lg-3">
        <p class="help-block">
            Hier können Sie die Aufnahmeposition des Bilds angeben bzw. korrigieren. 
            Mit der Google Maps Suche können Sie den gewünschten Kartenausschnitt suchen.<br><br>
            
            Klicken Sie auf die gewünschte Stelle, um den rote Pfeil für die relevante Aufnahmeposition zu setzen. Der blaue Pfeil gibt 
            weiterhin die originale Aufnahmeposition an (falls im Photo vorhanden). <br><br>

            Die nächstliegende Adresse wird automatisch von Google Maps ermittelt und als Ortsangabe übernommen.
        </p>
    </div>
</div>