<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Citation */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\DetailView;
use kartik\markdown\Markdown;
use frontend\models\PicturePrintForm;


$this->title = $model->name.' [Anschreiben]';

$printParameters = new PicturePrintForm();
$printParameters->visibility='unchanged';

?>
<style>
    body {
        width: 21cm;
    }
    .container {
        width: 100%;
    }
</style>
<div class="citation-print">

    <div class="alert alert-info alert-dismissable" style="margin-top: 10px">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        Sie können die Seite nun anpassen, die meisten Inhalte können Sie direkt im Editor ändern. Clicken Sie einfach auf die entsprechenden Stellen.<br><br>
        Sie können hierbei die Texte anpassen, vor allem aber auch den Abstand der Adresse zum oberen Rand für das Adressfenster.<br><br>
        Wenn Sie zufrieden sind, drucken Sie die Seite auf dem Drucker aus oder speichern Sie diese als PDF.  
        <br><br>
        <b><i>Sie müssen diese Box vor dem Drucken mit dem Kreuz rechts oben zumachen.</i></b>
    </div>    

    <p contenteditable="true"><br><br><br><br></p>
    <p contenteditable="true"><?=Yii::$app->formatter->format($model->recipient_address,'ntext') ?></p>

    <p contenteditable="true"><br><br></p>
    <p contenteditable="true"><b><br><?=$model->name?></b></p>
    <p contenteditable="true"><br><br></p>
    <p contenteditable="true">Sehr geehrte Damen und Herren,</p>

    <p contenteditable="true"></p>

    <?php if ($model->type == 'citation') : ?>
    
    <p contenteditable="true">anbei wegen der notwendigen Schriftform die Kurzzusammenstellung von Anzeigen, um deren Umsetzung ich bitten möchte. Die Details zu den Anzeigen finden Sie unter der URL/dem QR-Code.</p>
    <p contenteditable="true">Eine Kopie meines Personalausweises habe ich beigefügt.</p>
    
    <?php else : ?>
    
    <p contenteditable="true">anbei wegen der notwendigen Schriftform die Kurzzusammenstellung meines Anliegens, um deren Bearbeitung ich bitten möchte. Die Details zu meinem Anliegen finden Sie unter der URL/dem QR-Code.</p>
    
    <?php endif; ?>
    <hr>
    <div>
        <div>
        <img src="<?= Url::to(['qrcode','id'=>$model->id])?>" style="float: left; margin-right: 10px" /> Die eigentlichen Informationen erhalten Sie über Einscannen des QR-Codes oder händisches Aufrufen des Links unten. 
        <br><br><b>Dieser Link gibt Ihnen Lesezugriff und daher dürfen Sie den Link nur Personen weitergeben, die diesen Lesezugriff auch haben dürfen!</b>
        </div>
        <div style="clear: left"><?= Url::to($model->printout_url)?></div>
    </div>
    <hr>
    <p contenteditable="true"><br><br></p>
    
    <p contenteditable="true">Mit freundlichen Grüßen</p>
    <p contenteditable="true"><br><br><br></p>

    <div style="page-break-before: always;"></div>
    <h3 contenteditable="true">Übersicht der Vorfälle</h3>
    <?php echo $this->render('_overviewlist', [
        'model' => $model,
        'printParameters' => $printParameters,
    ]) ?>
    
</div>
