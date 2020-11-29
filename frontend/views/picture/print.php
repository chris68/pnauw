<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */

use frontend\models\PicturePrintForm;

$this->title = 'Vorfall';
if (!empty($model->vehicle_reg_plate)) {
    $this->title .= ' - '.$model->vehicle_reg_plate;
}
$this->title .= ' - '.substr($model->taken,0,10); // Add the date part
?>
<style>
    body {
        width: 21cm;
    }
    .container {
        width: 100%;
    }
</style>
<div class="picture-print">

    <div class="alert alert-info alert-dismissable" style="margin-top: 10px">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" onclick="var paras = document.getElementsByClassName('delete-before-printing');while(paras[0]) {paras[0].parentNode.removeChild(paras[0]);}" >&times;</a>
        Drucken Sie diese Seiten nun auf dem Drucker oder speichern Sie es als PDF.
        <br/><br/>
        <b><i>Sie müssen diese Box vor dem Drucken mit dem Kreuz rechts oben zumachen. Dann verschwinden auch die Edit-Buttons</i></b>
    </div>    
    
    <?php
        echo $this->render('_printpicture_complaint', [
            'model' => $model,
            'printParameters' => new PicturePrintForm(),
        ]);
    ?>
</div>
