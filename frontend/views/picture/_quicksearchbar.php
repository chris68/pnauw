<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\PictureSearch */
use yii\helpers\Url;
?>

<div class="btn-toolbar" style="margin-top: 10px;">
    <div class="btn-group">
        <button type="button" class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
            Karte <span class="caret"></span>
        </button>
          <ul class="dropdown-menu" id="quicksearch-map" role="menu" style="z-index: 100000;">
              <li><a data-value="bind" href="#">Ausschnitt <b>begrenzt</b> Suchergebnis</a></li>
              <li><a data-value="dynamic" href="#">Ausschnitt <b>gemäß</b> Suchergebnisse</a></li>
                <li class="divider"></li>
              <li><a data-value="gps" href="#">Ausschnitt auf <b>GPS-Standort</b> setzen</a></li>
          </ul>
    </div>
    <div class="btn-group">
        <button type="button" class="btn btn-xs dropdown-toggle" data-toggle="dropdown" style="margin-left:10px;">
            Zeitraum <span class="caret"></span>
        </button>
          <ul class="dropdown-menu" id="quicksearch-time" role="menu" style="z-index: 100000;">
            <li><a data-value="0;0" href="#">Heute</a></li>
            <li><a data-value="-1;0" href="#">Gestern &amp; heute</a></li>
            <li class="divider"></li>
            <li><a data-value="-7;0" href="#">Eine Woche zurück</a></li>
            <li><a data-value="-30;0" href="#">Einen Monat zurück</a></li>
            <li><a data-value="-365;0" href="#">Ein Jahr zurück</a></li>
            <li class="divider"></li>
            <li><a data-value="" href="#">Keine Einschränkung</a></li>
          </ul>
    </div>
    <?php if ($model->scenario == 'private' || $model->scenario == 'admin' ): ?>
    <div class="btn-group">
        <input type="text" size="10" maxlength="10" autocomplete="off" placeholder="Kennzeichen" id="quicksearch-vehicle-reg-plate"/>
    </div>
    <?php endif; ?>
    <div class="btn-group">
        <button type="button" data-url="<?=Url::toRoute([Yii::$app->controller->getRoute()])?>" id="quicksearch-cancel" class="btn btn-xs" style="margin-left:10px;"><span class="glyphicon glyphicon-remove-circle"></span></button>
        <button type="button" id="quicksearch-refresh" class="btn btn-xs" style="margin-left:10px"><span class="glyphicon glyphicon-refresh" style="color:blue"></span></button>
    </div>
</div>
