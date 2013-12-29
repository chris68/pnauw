<?php
/* @var $this yii\web\View */
?>

<div class="btn-group" style="margin-top: 10px;">
	<div class="btn-group">
	<div class="btn-group">
		<button type="button" class="btn btn-xs dropdown-toggle" data-toggle="dropdown" style="margin-left:10px;">
			Karte <span class="caret"></span>
		</button>
		  <ul class="dropdown-menu" id="search-map" role="menu">
			  <li><a title="bind" href="#">Ausschnitt <b>begrenzt</b> Suchergebnis</a></li>
			  <li><a title="dynamic" href="#">Auschnitt <b>gemäß</b> Suchergebnisse</a></li>
				<li class="divider"></li>
			  <li><a title="gps" href="#">Auschnitt auf <b>GPS-Standort</b> setzen</a></li>
		  </ul>
	</div>
		<button type="button" class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
			Zeitraum <span class="caret"></span>
		</button>
		  <ul class="dropdown-menu" id="search-time" role="menu">
			<li><a title="0;0" href="#">Heute</a></li>
			<li><a title="-1;0" href="#">Gestern &amp; heute</a></li>
			<li class="divider"></li>
			<li><a title="-7;0" href="#">Eine Woche zurück</a></li>
			<li><a title="-30;0" href="#">Einen Monat zurück</a></li>
			<li><a title="-365;0" href="#">Ein Jahr zurück</a></li>
			<li class="divider"></li>
			<li><a title="-365;0" href="#">Keine Einschränkung</a></li>
		  </ul>
	</div>
	<button type="button" title="<?=Yii::$app->getUrlManager()->createUrl(Yii::$app->controller->getRoute())?>" id="search-cancel" class="btn btn-xs" style="margin-left:10px;"><span class="glyphicon glyphicon-remove-circle"></span></button>
	<button type="button" id="search-refresh" class="btn btn-xs" style="margin-left:10px;"><span class="glyphicon glyphicon-refresh"></span></button>
	
</div>
