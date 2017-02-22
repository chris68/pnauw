<?php
/* @var $this yii\web\View  */
/* @var $model frontend\models\Picture  */
/* @var $form yii\bootstrap\ActiveForm  */

use \yii\helpers\Html;
use \frontend\models\Picture;
use \common\models\User;

?>
<div class="row">
    <div class="col-lg-3">
        <?= $form->field($model, 'incident_id')->dropDownList(frontend\models\Incident::dropDownList()) ?>
        <?php if ($model->scenario == Picture::SCENARIO_DEFAULT) : ?>
        <?= frontend\widgets\VehicleIncidentHistory::widget(
                [
                    'picture' => $model,
                ]
            )
        ?>
        <?php endif;?>
        <?= $form->field($model, 'action_id')->dropDownList(frontend\models\Action::dropDownList()) ?>
        <?= $form->field($model, 'citation_id')->dropDownList(frontend\models\Citation::dropDownList())->hint('Anzeigen müssen Sie vorher anlegen') ?>
        <?= $form->field($model, 'vehicle_reg_plate')->textInput(['placeholder' => 'Optionale Erfassung (nicht öffentlich)']) ?>
        <?= $form->field($model, 'vehicle_country_code')->dropDownList(frontend\models\VehicleCountry::dropDownList()) ?>
    </div>

    <?php if ($model->scenario == Picture::SCENARIO_DEFAULT) : ?>

    <div class ="col-lg-3">
        <div>
            <div class="form-group">
            <?= Html::label('Bildausschnitt (Nummernschild)','picture-clip-canvas') ?>
            <button style="margin-bottom: 5px" onclick="excuteAlpr(); return false;">Kennzeichen automatisch ermitteln</button>
            <canvas id="picture-clip-canvas" class="img-responsive" style = "margin-bottom: 7px;">
            <?php
                $this->registerJs("updatePictureClipCanvas();", \yii\web\View::POS_READY);
            ?>
            </div>
            <!-- Hidden fields are not reset upon a form reset; therefore, we need to use normal fields which we hide -->
            <?= Html::activeInput('text', $model, 'clip_x', ['id'=>'picture-clip-x', 'style' => 'display:none', ]) ?>
            <?= Html::activeInput('text', $model, 'clip_y', ['id'=>'picture-clip-y', 'style' => 'display:none', ]) ?>
            <div class="form-group">
            <?= Html::label('Zoom') ?>
            <!-- A range field seems not to be reset upon a form reset; but what can we do? -->
            <?= Html::activeInput('range', $model, 'clip_size', ['id'=>'picture-clip-size', 'min' => 5, 'max' => 70, ]) ?>
            </div>
            <?= $form->field($model,'citation_affix')->textarea(['rows' => 5, 'placeholder' => 'Hier können sie weitere Angaben für eine potentielle Anzeige machen (Nicht öffentlich, sondern nur für den Empfänger der Anzeige)']) ?>
        </div>
    </div>
    
    <div class="col-lg-3">
        <?=
        frontend\widgets\ImageRenderer::widget(
            [
                'image' => $model->mediumImage,
                'size' => 'medium',
                'options' => ['id' => 'picture-image', 'class' => 'img-responsive'],
            ]
        );
        ?>
        <?php if ($model->isNewRecord):?>
        <div class="form-group" style="margin-top: 7px;">
            <?= Html::activeInput('text', $model, 'taken', ['id'=>'picture-taken', 'style' => 'display:none', ]) ?>
            <?= Html::activeInput('text', $model, 'image_dataurl', ['id'=>'picture-image-dataurl', 'style' => 'display:none', ]) ?>
            <?= Html::input('file', 'file_name', NULL, ['accept' => 'image/*', 'capture' => true, 'id' => 'picture-image-upload', 'hint' => 'Drücken Sie hier, um die Kamera zu aktivieren']); ?>
            <p class="help-block">Drücken Sie optional hier oder den Button "Bild aufnehmen" oben, um ein eigenes Bild mit der Kamera aufzunehmen.</p>
        </div>
        <?php endif;?>
        <p class="help-block">Setzen Sie den Bildausschnitt durch Antippen des Nummernschilds und Anpassen des Zooms<br/>Oder nutzen Sie am besten die automatische Erkennung</p>
    </div>
    <?php endif;?>
</div>




<?php
    if ($model->isNewRecord && $model->scenario == Picture::SCENARIO_DEFAULT) {
        $accuracy = User::findIdentity(Yii::$app->user->getId())->appdata['geo_accuracy'];
        $accuracy = (int)(empty($accuracy)?0:$accuracy);
        $this->registerJs(
<<<JAVASCRIPT
            // After a picture has been captured and a proper location has been found we want to toggle of the auto geopositioning
            // This variable tracks whether a pic has been actually taken
            var picture_captured = false;
                
            function now_iso() {
                // Return the timestamp in the local client time
                var now = new Date();
                var pad = function(num) {
                    var norm = Math.abs(Math.floor(num));
                    return (norm < 10 ? '0' : '') + norm;
                };
                return now.getFullYear()
                    + '-' + pad(now.getMonth()+1)
                    + '-' + pad(now.getDate())
                    + ' ' + pad(now.getHours())
                    + ':' + pad(now.getMinutes())
                    + ':' + pad(now.getSeconds())
                ;
            }

            $("#picture-taken").val(now_iso());
            
            if ($("#picture-image-dataurl").val() != '') {
                // Restore the pic from the dataurl if given
                $("#picture-image").attr("src", $("#picture-image-dataurl").val());

                setTimeout(function() {
                    // The image will need some time to be display so update the canvas a little later
                    updatePictureClipCanvas();

                }, 100);
            }

            // Resize the file upload in the internal canvas
            $("#picture-image-upload").ImageResize(
                {
                    longestEdge: 1024,
                    onImageResized: function (imageData) {
                        // Set the time when the picture has been taken
                        $("#picture-taken").val(now_iso());

                        // Log that the pic has been taken
                        picture_captured = true;

                        // Save the image data url in the hidden input field
                        $("#picture-image-dataurl").val(imageData);

                        // Set the picture to the resized image and update the clip canvas
                        $("#picture-image").attr("src", imageData);
                        setTimeout(function() {
                            // The image will need some time to be display so update the canvas a little later
                            updatePictureClipCanvas();

                        }, 100);
                    },
                    onFailure: function (message) {
                        alert(message);
                    }
                }
            );

            toggleLocate(map,true);
            var positionLayerGroup = L.layerGroup([]);
            positionLayerGroup.addTo(map);

            map.on('locationerror', function(e) {
                alert(e.message);
            });

            map.on('locationfound', function(e) {
                positionLayerGroup.clearLayers();
                positionLayerGroup.addLayer(L.circle(e.latlng, e.accuracy / 2, {opacity:0.2}));
                $('#picture-map-loc-lat-org').val(e.latlng.lat);
                $('#picture-map-loc-lng-org').val(e.latlng.lng);
                $('#picture-map-loc-lat').val(e.latlng.lat);
                $('#picture-map-loc-lng').val(e.latlng.lng);
                updateMarkerOrg();
                
                if (picture_captured && e.accuracy < {$accuracy} ) {
                    // Switch off geopositining when a reasonably accurate location has been found after the photo as been taken 
                    // Reason: people continue to walk on and you want the position where the photo was taken and not where you continued to document
                    $('#picture-map-geopositioning').prop('checked',false);
                    picture_captured = false;
                    toggleLocate(map,false);
                } 
                
                updateMarker();
            });
JAVASCRIPT
            ,
             \yii\web\View::POS_READY
        );
    }
?>
