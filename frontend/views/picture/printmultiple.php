<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $printParameters frontend\models\PicturePrintForm */

use yii\helpers\Url;


$this->title = 'Vorfälle - '.date('Y-m-d');
?>
<style>
    body {
        width: 21cm;
    }
    .container {
        width: 100%;
    }
    @media print {
        .leaflet-control-attribution {
            font-size: 7px;
        }   
    }
    @media screen {
        .leaflet-control-attribution {
            font-size: 9px;
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
    


    <?php if ($printParameters->overviewmap != 'none'): ?>
    <?php
      \frontend\views\picture\assets\PictureOverviewmapAsset::register($this);
    ?>
    <script type="text/javascript">
            var overviewmapInteractive=false, overviewmapSource =
            "<?php 
                {
                    echo Url::toRoute(['picture/geodata','private' => true,'s' => Yii::$app->getRequest()->get('s')]);
                }
              ?>";
    </script>
    <?php endif ?>
    <?php if ($printParameters->overviewmap == 'before'): ?>
    
    <h2>Übersichtskarte</h2>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group" style="margin-top: 10px; margin-bottom: 10px;">
            <div id="overviewmap" style="height: 800px;"></div>
        </div>
    </div>
    <div style="page-break-before: always;"></div>
    <?php endif ?>

    <?php
        /* var $pic frontend\models\Picture */
        foreach ($models as $pic) {
            echo $this->render('//picture/_printpicture_complaint', [
                'model' => $pic,
                'printParameters' => $printParameters,
            ]);
        }
    ?>
    
    <?php if ($printParameters->overviewmap == 'after'): ?>
    <div style="page-break-before: always;"></div>
    <h2>Übersichtskarte</h2>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group" style="margin-top: 10px; margin-bottom: 10px;">
            <div id="overviewmap" style="height: 800px;"></div>
        </div>
    </div>
    <?php endif ?>
</div>
