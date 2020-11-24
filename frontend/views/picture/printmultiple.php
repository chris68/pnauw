<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Vorfälle - '.date('Y-m-d');
?>
<style>
    body {
        width: 21cm;
    }
    .container {
        width: 100%;
    }
</style>
<div class="picture-printmultiple">

    <?php
        $models = $dataProvider->getModels();
    ?>
    <div class="alert alert-info alert-dismissable" style="margin-top: 10px">
    <?php if ($dataProvider->getPagination()->getPageCount() > 1): ?>
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        Es wurden <strong><?= $dataProvider->getCount()?> Vorfälle</strong> ausgegeben.
        Die Auswahl enthielt noch weitere Bilder, die aber nicht mehr ausgeben wurden, weil der Server bei der Ausgabe von insgesamt <strong><?= $dataProvider->getTotalCount()?> Vorfällen</strong> zu stark belastet würde
        <br/><br/>
    <?php endif ?>
        <a href="#" class="close" data-dismiss="alert" aria-label="close" onclick="var paras = document.getElementsByClassName('delete-before-printing');while(paras[0]) {paras[0].parentNode.removeChild(paras[0]);}" >&times;</a>
        Drucken Sie diese Seiten nun auf dem Drucker oder speichern Sie es als PDF.
        <br/><br/>
        <b><i>Sie müssen diese Box vor dem Drucken mit dem Kreuz rechts oben zumachen. Dann verschwinden auch die Edit-Buttons</i></b>
    </div>    
    
    <?php
        /* var $pic frontend\models\Picture */
        foreach ($models as $pic) {
            echo $this->render('//picture/_printpicture_complaint', [
                'model' => $pic,
                'model_type' => 'protected',
            ]);
        }
    ?>
</div>
