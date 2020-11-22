<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Citation */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\widgets\DetailView;
use kartik\markdown\Markdown;


if ($model->type == 'citation') {
    $this->title = 'Privatanzeige Gehwegparken';
    $this->title .= ' - '.$model->name;
}
elseif ($model->type == 'complaint') {
    $this->title = 'Beschwerde Gehwegparken';
    $this->title .= ' - '.$model->name;
}
elseif ($model->type == 'protected' || $model->type == 'public') {
    $this->title = $model->name;
}
?>
<style>
    body {
        width: 21cm;
    }
    .container {
        width: 100%;
    }
    @media print {
        .citation-print .leaflet-control-attribution {
            font-size: 7px;
        }   
    }
    @media screen {
        .citation-print .leaflet-control-attribution {
            font-size: 9px;
        }   
    }
</style>
<div class="citation-print">

    <?php if ($model->type == 'citation') : ?>
    
    <div class="alert alert-info alert-dismissable" style="margin-top: 10px">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        Drucken Sie diese Seiten nun auf dem Drucker oder speichern Sie es als PDF. Sie können es 
        <ul>
            <li>mit einer Seite pro Blatt  doppelseitig ausdrucken (dann vorne die Details, hinten das Bild), oder </li>
            <li>mit zwei Seiten pro Blatt, einseitig oder doppelseitig (dann Details und Bild auf einer Seite), oder </li>
            <li>mit 4,8 oder 16 Seiten pro Blatt, einseitig oder doppelseitig, für eine Miniaturübersicht </li>
        </ul>
        <br/>
        Sie sollten mit der Skalierung ein bisschen spielen und die Größte nehmen, sodass alles noch draufpasst. 140% liefert meist gut Werte.
        <br/><br/>
        Bei vielen Vorfällen hat es sich bewährt, der Bußgeldstelle eine kompakte Miniaturübersicht mit 8 Vorfällen pro Seite ausgedruckt in 
        Papierform zur Verfügung zu stellen und die Originale mit einem Vorfall pro Seite im Internet hochzuladen und den Zugriffslink (am 
        besten mit <a href='tinyurl.com'>tinyurl.com</a> verkürzen) dann im Anschrieben mitzuteilen
        <br/><br/>
        <b><i>Sie müssen diese Box vor dem Drucken mit dem Kreuz rechts oben zumachen.</i></b>
    </div>    
    
    <?php else : ?>
    
    <div class="alert alert-info alert-dismissable" style="margin-top: 10px">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        Drucken Sie diese Seiten nun auf dem Drucker oder speichern Sie es als PDF.
        <br/><br/>
        <b><i>Sie müssen diese Box vor dem Drucken mit dem Kreuz rechts oben zumachen.</i></b>
    </div>    
    
    <h1><?= $this->title ?></h1>
    <?php if ($model->type == 'complaint') : ?>
    <p>
        Dies ist eine informelle Beschwerde (<b>keine Anzeige!</b>), die über die Plattform <b>Parke-nicht-auf-unseren-Wegen.de</b> erstellt wurde. Mit dieser Plattform 
        können betroffene Bürger Gehwegparker dokumentieren, die Autofahrer auf ihr missbräuchliches Parken hinweisen und das Fehlverhalten an die entsprechenden Behörden melden. Was hiermit gerade geschieht.
    </p>
    <p>
        Die Erwartung ist, dass die entsprechende Behörde an den gemeldeten Stellen die Kontrollen intensiviert und das Fehlverhalten der Autofahrer damit abgestellt wird.
    </p>
    <h2>Spezifische Angaben für die Beschwerde</h2>
    <?php endif; ?>
    <?=Markdown::convert(Html::encode($model->description))?>
    <div style="page-break-before: always;"></div>
    
    <?php
      \frontend\views\picture\assets\PictureOverviewmapAsset::register($this);
    ?>
    <script type="text/javascript">
            var overviewmapInteractive=false, overviewmapSource =
            "<?php 
                {
                    echo Url::toRoute(['picture/geodata','s[citation_id]'=>$model->id,'private' => true]);
                }
              ?>";
    </script>
    <h2>Übersichtskarte</h2>
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group" style="margin-top: 10px; margin-bottom: 10px;">
            <div id="overviewmap" style="height: 800px;"></div>
        </div>
    </div>
    <div style="page-break-before: always;"></div>
    <?php endif; ?>
    <?php
        /* var $pic frontend\models\Picture */
        foreach ($model->getPictures()->all() as $pic) {
            if ($model->type == 'citation') {
                echo $this->render('//picture/_printpicture_citation', [
                    'model' => $pic,
                ]);
            } else {
                echo $this->render('//picture/_printpicture_complaint', [
                    'model' => $pic,
                    'model_type' => $model->type
                ]);
                echo '<div style="page-break-after: auto;"></div>';
            } 
        }
    ?>
    <?php if ($model->type == 'citation') : ?>
    <h1><?= $this->title ?></h1>
    <p>
        Dies ist eine Privatanzeige, die über die Plattform <b>Parke-nicht-auf-unseren-Wegen.de</b> erstellt wurde. Mit dieser Plattform 
        können betroffene Bürger Gehwegparker dokumentieren, die Autofahrer auf ihr missbräuchliches Parken hinweisen und, wenn es nicht hilft
        oder das Parkverhalten nicht tolerierbar ist, auch anzeigen. Was hiermit gerade geschieht.
    </p>
    <h2>Zeuge und weitere spezifische Angaben für die Anzeige</h2>
    <p><?=Markdown::convert(Html::encode($model->description))?></p>
    <h2>Generelle Erläuterungen</h2>
    <p>
        Unter Vorfall ist genau dokumentiert, wie der Anzeiger die Lage entschätzt. Wenn es dort heißt <b>Gehwegparken (mit Behinderung)</b>, 
        dann ist in der Regel das erhöhte Verwarnungsgeld angemessen. Wenn dort die längere Standzeit über <b>(> 1h)</b> dokumentiert ist, dann ist 
        auch das erhöhte Verwarnungsgeld angemessen. In der Regel ist die längere Standzeit dann ja auch durch ein weiteres Photo dokumentiert.
    </p>
    <p>
        Wenn ein Auto an mehreren Tagen aufgeführt ist, dann ist dies in der Regel (wenn dem nicht indiviudell und ausdrücklich wiedersprochen wird) auch als <b>Mehrfachanzeige</b> gemeint. 
    </p>
    <h2>Information bei Nichtumsetzung</h2>
    <p>
        Wenn die Anzeigen z.B. aus Gründen des Ermessenspielraums im Rahmen des Opportunitätsprinzips nicht in Verwarnungen umgesetzt wurden, dann bittet der <b>Anzeiger
        gemäß  § 46 Abs. 1 OWiG i.V.m. § 171 S.1 StPO um eine kurze Info</b> z.B. an die in der Regel ja angegebene Emailadresse mit einer <b>nachvollziehbaren Begründung für die Nichtumsetzung</b>.
    </p>
    <p>
        Dies gilt in der Regel (d.h. wenn dem nicht indiviudell und ausdrücklich wiedersprochen wird) weniger bei Nichtumsetzen von vereinzelten Anzeigen/Vorfällen - 
        hier soll in der Regel aus Effizienzgründen auf die Korrektheit der Entscheidung vertraut werden. 
        Sondern es geht vielmehr darum, dass ein Nichtumsetzen <b>aller oder sehr vieler Anzeigen</b> rechtlich eher nicht durch das Opportunitätsprinzip
        abgedeckt wäre. Und dann will der Anzeiger eventuell die Möglichkeit des Rechtsweges oder der Dienstaufsichtsbeschwerde einschlagen.
        Und daher muss sichergestellt sein, dass die Anzeigen nicht einfach und in großen Stil ohne weitere Benachrichtigung eingestellt werden.
        Denn der Anzeiger macht die Sache ja meist nicht aus Spass, sondern eher aus Notwehr, weil es die offiziellen Stellen nicht machen!
    </p>
    <?php endif; ?>
</div>
