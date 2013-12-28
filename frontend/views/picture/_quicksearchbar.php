<?php
/* @var $this yii\web\View */
?>

<div class="btn-group" style="margin-top: 10px;">
	<button type="button" class="btn btn-xs dropdown-toggle" data-toggle="dropdown">
		Zeitraum <span class="caret"></span>
	</button>
	  <ul class="dropdown-menu" role="menu">
		<li><a href="#">Heute</a></li>
		<li><a href="#">Heute &amp; gestern</a></li>
		<li class="divider"></li>
		<li><a href="#">Eine Woche zurück</a></li>
		<li><a href="#">Ein Monat zurück</a></li>
		<li><a href="#">Ein Jahr zurück</a></li>
	  </ul>
	<button type="button" id="picture-heatmap-goto-current-geolocation" class="btn btn-xs" style="margin-left:10px;">Zum GPS-Standort</button>
	<button type="button" id="search-refresh" class="btn btn-xs" style="margin-left:10px;">Aktualisieren</button>
</div>
