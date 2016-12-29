<?php

/* @var $this yii\web\View */
/* @var frontend\models\Flyer $model */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Assist;
use kartik\markdown\Markdown;

?>
<style>
    body {
        width: 21cm;
    }
    .container {
        width: 100%;
    }
</style>
<?php
$this->title = 'Zettel '.$model->name;

for ($p=0;$p<1;$p++) :
?>
<div class="site-test">
    <?php
    for ($r=0;$r<3;$r++) :
    ?>
    <div class="row">
        <?php
        for ($c=0;$c<2;$c++) :
        ?>
        <div class="col-sm-6 col-md-6 col-lg-6">
        <div>
            <?=Markdown::convert(Html::encode($model->flyertext))?>
        </div>
        <hr>
        <div>
            <img src="<?= Url::to(['qrcode','secret'=>$model->secret])?>" style="float: left; margin-right: 10px" /> <br>Weitere Infos erhalten Sie über Einscannen des QR-Codes oder manuelles Aufrufen des Links unten
            <div style="clear: left; margin-bottom: 10px"><?= Url::to(['flyer/show','secret'=>$model->secret],true)?></div>

        </div>
        </div>
    <?php
    endfor;
    ?>
    </div>
    <?php
    endfor;
    ?>

</div>
<p>
</p>
<hr style="page-break-after: always;">
<?php
endfor;
?>
