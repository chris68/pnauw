<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */
/* @var $form yii\bootstrap\ActiveForm */

use \yii\helpers\Html;
use \frontend\models\Picture;
?>

<div class="row">
    <div class="col-lg-4">
        <div class ="form-group">
        <?php echo Html::label('Nächstliegende Adresse (ermittelt via OpenStreetMap Nominatim)','picture-map-nearest-address'); ?>
            <p id="picture-map-nearest-address"><i>Repositionieren Sie den blauen Pfeil für eine erneute Adressermittlung</i></p>
        </div>
        <?= $form->field($model,'loc_formatted_addr')->textInput(['id'=>'picture-map-loc-formatted-addr','placeholder' => 'Wird gemäß Marker autom. ermittelt']) ?>
        <!-- Hidden fields are not reset upon a form reset; therefore, we need to use normal fields which we hide -->
        <?= Html::activeInput('text', $model,'loc_lat', ['id'=>'picture-map-loc-lat', 'style' => 'display:none', ]) ?>
        <?= Html::activeInput('text', $model,'loc_lng',['id'=>'picture-map-loc-lng', 'style' => 'display:none', ]) ?>
        <?= Html::activeHiddenInput($model,'org_loc_lat', ['id'=>'picture-map-loc-lat-org', ]) ?>
        <?= Html::activeHiddenInput($model,'org_loc_lng',['id'=>'picture-map-loc-lng-org', ]) ?>
        <?php if ($model->isNewRecord && $model->scenario == Picture::SCENARIO_DEFAULT):?>
        <div class="form-group">
            <label for="picture-map-geopositioning">Automatisches Geopositionieren</label>
            <input type="checkbox" onclick="toggleLocate(map,$('#picture-map-geopositioning').prop('checked'))" id="picture-map-geopositioning" value="on" checked/>
            <p class="help-block">
                Hier können Sie die automatische Geopositionierung jederzeit selbst anschalten oder aussschalten.
            </p>
        </div>

        <?php endif; ?>
    </div>
    <div class="col-lg-4">
        <div style="width: 300px; height: 300px;" id="picture-map-canvas"></div>
        
    </div>
    <div class="col-lg-3">
        <p class="help-block">
            <?php if ($model->isNewRecord && $model->scenario == Picture::SCENARIO_DEFAULT) :?>
            Hier müssen Sie die Aufnahmeposition des Bilds setzen. Hierbei hilft Ihnen die automatische Positionierung, welche ihr mobiles Gerät 
            ermittelt hat (sie müssen dafür die Freigabe im Browser erteilen). Ihre Position wird mit einer Kamera angezeigt, die Genauigkeit mit einem 
            blauen Kreis. <br/>
            
            Wenn Sie ein Photo aufgenommen haben und die Genauigkeit ausreichend ist, dann stoppt die automatische Ermittlung (siehe Checkbox). Sie müssen dann den 
            genauen Ort mit dem Finger setzen (=> blauer Pfeil erscheint). Daraufhin wird dann die Adresse ermittelt.<br/>
            <?php else :?>
            Hier können Sie die Aufnahmeposition des Bilds angeben bzw. korrigieren. 
            Mit der Suchlupe oben rechts in der Karte können Sie den gewünschten Kartenausschnitt suchen.<br><br>
            
            Verschieben Sie den blauen Pfeil oder klicken Sie auf die gewünschte Stelle, um den blauen Pfeil für die relevante Aufnahmeposition zu setzen. Das kleine Kamerasymbol gibt
            weiterhin die originale Aufnahmeposition an (falls im Photo vorhanden). <br><br>

            Die nächstliegende Adresse wird dann automatisch von OpenStreetMap Nominatim ermittelt und als Ortsangabe übernommen. Je weiter Sie reinzommen, desto
            genauer wird die Adresse ermittelt (bis auf Hausnummern genau). Sie können die einmal ermittelte Adresse auch noch verbessern/anpassen.
            <?php endif;?>
        </p>
    </div>
</div>  