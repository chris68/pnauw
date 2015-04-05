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
        Version 1.3 (??.04.2015)
    </h3>
    <p>
        
    </p>
    <ul>
        <li>Es gibt nun eine Benutzerverwaltung (eigentlich schon mit Version 1.2.2) </li>
        <li>Die Übersichtskarten wurden von Google Maps auf die Leaflet Library mit dem Karten von OpenStreetMap umgestellt</li>
        <li>Das Anzeige- und Zommverhalter bei den neuen Übersichtskarten ist durch die Umstellung noch einmal besser geworden; vor allem das Setzen auf die aktuelle GPS Position funktioniert nun wesentlich besser</li>
        <li>Die Autofahrer sehen damit nun noch schneller und einfacher via dem Absprung "Heute&amp;hier" ihren eigenen Vorfall</li>
        <li>Vorfälle, die älter als ein Jahr sind (gemäß Aufnahmedatum), werden öffentlich nur noch mit weniger Details und ohne Bild angezeigt</li>
    </ul>
    <h3>
        Version 1.2 (15.11.2014)
    </h3>
    <p>
        Interne Stabilisierung und viele neue Funktionen vor allem für den Außeneinsatz
    </p>
    <ul>
        <li>Das darunter liegende Framework Yii2 wurde auf einen Produktivstand (2.0.0) aktualisiert</li>
        <li>Das Anzeige- und Zoomverhalten bei den Karten (Heatmaps) ist deutlich besser</li>
        <li>Es werden an vielen Stellen mehr Felder angezeigt</li>
        <li>Beim <?= Assist::help('Hochladen','picture-upload')?> von Bildern können nun Vorgabewerte gesetzt werden</li>
        <li>Es gibt keine störende Größenbeschränkungen beim Hochladen der Bilder mehr</li>
        <li>Es gibt für <?= Assist::help('vertrauenswürdige Nutzer','user-level-trusted')?> die Möglichkeit, über FTP Bilder zu übermitteln und dann vom <?= Assist::help('Server hochzuladen','picture-serverupload')?></li>
        <li>Beim <?= Assist::help('Aufnehmen von Bildern','picture-capture')?> erscheint nun eine Karte, in der der aktuelle Standort angezeigt wird</li>
    </ul>    
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
