<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */

$this->title = 'Vorfall';
if (!trim($model->vehicle_reg_plate)=='') {
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

    <?php
        echo $this->render('_printpicture', [
            'model' => $model,
        ]);
    ?>
</div>
