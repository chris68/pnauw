<?php
/* @var $this yii\web\View */
use yii\helpers\Url;
?>

<div class="btn-group" style="margin-top: 10px;">
	<div class="btn-group">
	<div class="btn-group">
		<button type="button" class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
			Karte <span class="caret"></span>
		</button>
		  <ul class="dropdown-menu" id="search-map" role="menu">
			  <li><a data-value="bind" href="#">Ausschnitt <b>begrenzt</b> Suchergebnis</a></li>
			  <li><a data-value="dynamic" href="#">Ausschnitt <b>gemäß</b> Suchergebnisse</a></li>
				<li class="divider"></li>
			  <li><a data-value="gps" href="#">Ausschnitt auf <b>GPS-Standort</b> setzen</a></li>
		  </ul>
	</div>
		<button type="button" class="btn btn-xs dropdown-toggle" data-toggle="dropdown" style="margin-left:10px;">
			Zeitraum <span class="caret"></span>
		</button>
		  <ul class="dropdown-menu" id="search-time" role="menu">
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
	<button type="button" data-url="<?=Url::toRoute([Yii::$app->controller->getRoute()])?>" id="search-cancel" class="btn btn-xs" style="margin-left:10px;"><span class="glyphicon glyphicon-remove-circle"></span></button>
	<button type="button" id="search-refresh" class="btn btn-xs" style="margin-left:10px;"><span class="glyphicon glyphicon-refresh"></span></button>
	
</div>
