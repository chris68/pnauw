<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use frontend\helpers\Assist;

$this->title = 'Releasehistorie';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-releasehistory">
	<h1><?= $this->title ?></h1>
	<p>
		Die Plattform wird laufend weiterentwickelt und damit Sie schnell erkennen können, wann was neu hinzugekommen ist, haben wir hier die Releasehistorie veröffentlicht. Kleinere Änderungsrelease mit Fehlerkorrekturen werden hier jedoch nicht aufgeführt.
	</p>
	<h3>
		Version 1.2 (16.10.2014)
	</h3>
	<p>
		Darunter liegendes Framework Yii2 aktualisiert
	</p>
	<h3>
		Version 1.1 (19.01.2014)
	</h3>
	<p>
		Die Nutzbarkeit wurde extrem verbessert.
	</p>
	<ul>
		<li>Deutliche bessere und kontextsensitive <?= Assist::help('Hilfe','')?></li>
		<li>Kampagnen können nun von allen <?= Assist::help('vertrauenswürdigen Nutzern','user-level-trusted')?> angelegt/genutzt werden</li>
		<li>Bei Kampagnen und Anzeigen können Sie nun die <?= Assist::help('Markdown Syntax','markdown-syntax')?> nutzen</li>
	</ul>	
	<h3>
		Version 1.0 (29.12.2013)
	</h3>
	<p>
		Initialer Produktivstart ("Go-Live") mit extrem wenig Komfort.
	</p>
	<ul>
		<li>Bilder können hochgeladen, bearbeitet und veröffentlicht werden</li>
		<li>Anzeigen gehen rudimentär und für jeden</li>
		<li>Kampagnen können nur extrem speziell angelegt und genutzt werden</li>
	</ul>	
</div>
