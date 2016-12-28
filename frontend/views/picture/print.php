<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */


$this->title = 'Vorfall';
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
