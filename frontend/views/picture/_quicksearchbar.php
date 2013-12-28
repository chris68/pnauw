<?php
/* @var $this yii\web\View */
?>

<div class="btn-group" style="margin-top: 10px;">
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
	<button type="button" id="picture-heatmap-goto-current-geolocation" class="btn btn-xs" style="margin-left:10px;">Zum GPS-Standort</button>
	<button type="button" id="search-refresh" class="btn btn-xs" style="margin-left:10px;">Aktualisieren</button>
</div>
