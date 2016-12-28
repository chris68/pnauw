<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = 'Vorfälle';
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
    <?php if ($dataProvider->getPagination()->getPageCount() > 1): ?>
    <div class="alert alert-danger alert-dismissable">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        Es wurden <strong><?= $dataProvider->getCount()?> Vorfälle</strong> ausgegeben.
        Die Auswahl enthielt noch weitere Bilder, die aber nicht mehr ausgeben wurden, weil der Server bei der Ausgabe von insgesamt <strong><?= $dataProvider->getTotalCount()?> Vorfällen</strong> zu stark belastet würde
        <br/><br/>
        <i>Sie können diese Box mit dem Kreuz rechts zumachen.</i>
    </div>
    <?php endif ?>
    <?php
        /* var $pic frontend\models\Picture */
        foreach ($models as $pic) {
            echo $this->render('//picture/_printpicture', [
                'model' => $pic,
            ]);
        }
    ?>
</div>
