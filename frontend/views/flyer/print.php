<?php

/* @var $this yii\web\View */
/* @var $model frontend\models\Flyer */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Assist;
use kartik\markdown\Markdown;
use yii\helpers\HtmlPurifier;

?>
<style>
    body {
        width: 21cm;
    }
    .container {
        width: 100%;
    }
    .col {
        -webkit-column-count: 2; /* Chrome, Safari, Opera */
        -moz-column-count: 2; /* Firefox */
        column-count: 2;
    }
</style>
<?php
$this->title = 'Zettel '.$model->name;
?>
<div class="alert alert-info alert-dismissable" style="margin-top: 10px">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Drucken Sie diese Seite nun auf dem Drucker aus. Prüfen Sie vorher mit einer Testseite, dass wirklich alles auf eine Seite passt. Wenn die Seite nicht 2 spaltig mit je drei Zetteln pro Spalte aufgebaut ist,
    dann reduzieren Sie den Text solange, bis es auf eine Seite passt. Sobald alles gut aussieht, können Sie beim Drucken einfach sagen, dass Sie die Seite mehrmals ausdrucken wollen.
    <br/>
    Das Drucken funktioniert nur mit aktuellen Browsern (Firefox, Chrome getestet), Microsofts Edge versteht leider HTML 5 immer noch nicht korrekt und bricht nicht korrekt um.
    <br/><br/>
    <b><i>Sie müssen diese Box vor dem Drucken mit dem Kreuz rechts oben zumachen.</i></b>
</div>
<?php
for ($p=0;$p<1;$p++) :
?>
<div class="col">
    <?php
     for ($c=0;$c<2;$c++) :
     ?>
        <?php
        for ($r=0;$r<3;$r++)
        :?>
        <div class="flyer">
            <div>
                <?=HtmlPurifier::process(Markdown::convert($model->flyertext))?>
            </div>
            <hr>
            <div>
                <img src="<?= Url::to(['qrcode','secret'=>$model->secret])?>" style="float: left; margin-right: 10px" /> <br>Weitere Infos und eine Kontakt&shy;möglichkeit erhalten Sie über Einscannen des QR-Codes oder händisches Aufrufen des Links unten
                <div style="clear: left"><?= Url::to(['flyer/show','secret'=>$model->secret],true)?></div>
            </div>
        </div>
        <?php
        endfor;
        ?>
    <div style="break-after: column;-moz-break-after: column; -webkit-break-after: column"></div>
    <?php
    endfor;
    ?>
</div>
<?php
endfor;
?>
