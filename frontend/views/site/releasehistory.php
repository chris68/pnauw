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
        Version 2.1 (15.-16.01.2017)
    </h3>
    <p>
        Automatische Erkennung der Kfz-Kennzeichen und Arbeitsvorräte
    </p>
    <ul>
        <li>Die automatische Erkennung von Kfz-Kennzeichen (engl. ALPR - automatic licence plate recognition) ist nun ausreichend ausgereift</li>
        <li>Daher wurde diese nun auch in Parke-nicht-auf-unseren-Wegen eingebaut und es besteht nun die Möglichkeit, sich das Kennzeichen automatisch ermitteln zu lassen</li>
        <li>Damit das auch in Deutschland mit den notwendigen Leerzeichen gescheit funktioniert, muss man in den Applikationseinstellungen die häufig auftretenden Stadt bzw. Landkreiskennungen pflegen (z.B. KA;PF;GER)</li>
        <li>Bei der Bearbeitung besteht zudem nun die Möglichkeit, sich in der Suche einen Arbeitsvorrat zu definieren. Wenn man ein Bild bearbeitet hat, denn verschwindet es automatisch aus dem Arbeitsvorrat</li>
    </ul>
    <h3>
        Version 2.0 (29.12.2016)
    </h3>
    <p>
        Riesenverbesserung der Benutzerfreundlichkeit - die Webseite hat nun ein volles App-Feeling!
    </p>
    <ul>
        <li>Direktanlage der Vorfälle mit HTML5-Mitteln zur Bildübernahme direkt aus der Kamera</li>
        <li>Druckansicht eines Einzelbildes oder einer Bildauswahl, was ein direktes Drucken/Speichern als PDF auch im Gastmodus ermöglicht und womit die Unterlagen für eine Einzelanzeige sehr schnell und komplett anonym erstellt werden kann</li>
        <li>Es gibt nur die Möglichkeit, Zettel zu herstellen, dann auszudrucken und über einen QR-Code wird dann der Autofahrer oder Fußgänger auf die Webseite geleitet, wo man dann weitere Bechreibungen hinterlegen kann</li>
        <li>Die Mail bei einer Kontaktaufnahme zu Vorfällen/Bildern, Kampagnen und Zetteln geht nun an den Eigner des Objekts</li>
        <li>Bei alten Vorfällen werden nun automatisch die Bilder weiter verkleinert und zudem wird die Veröffentlichung irgendwann automatisch zurückgesetzt</li>
    </ul>
    <h3>
        Version 1.5 (24.-25.12.2016)
    </h3>
    <p>
        Mehr Sicherheit durch SSL und Verbesserungen bei der Benutzerfreundlichkeit
    </p>
    <ul>
        <li>Die ganze Seite ist nun mit SSL (https) verschlüsselt, womit nun auch wieder die GPS Funktionen funktionieren</li>
        <li>Es werden nun nur noch die Karten und der Adressermittlung von OpenStreetMap anstatt Google Maps genutzt (Vielen Dank an die Macher!!!)</li>
        <li>Kampagnen und Anzeigen können kopiert werden</li>
        <li>Kennzeichenschnellsuche direkt über der Übersichtskarte</li>
        <li>Massenverarbeitung beim Bearbeiten der Vorfälle</li>
    </ul>
    <h3>
        Version 1.4 (17.10.2015)
    </h3>
    <p>

    </p>
    <ul>
        <li>Es gibt nun eine Kommentarfunktion über die Diskussionsplattform disqus.com</li>
        <li>Es ist nun ein sogenannter Social Login via Facebook und Google möglich</li>
    </ul>
    <h3>
        Version 1.3 (05.04.2015)
    </h3>
    <p>
        
    </p>
    <ul>
        <li>Es gibt nun eine Benutzerverwaltung (eigentlich schon mit Version 1.2.2) </li>
        <li>Die Übersichtskarten wurden von Google Maps auf die Leaflet Library mit dem Karten von OpenStreetMap umgestellt</li>
        <li>Das Anzeige- und Zommverhalter bei den neuen Übersichtskarten ist durch die Umstellung noch einmal besser geworden; vor allem das Setzen auf die aktuelle GPS Position funktioniert nun wesentlich besser</li>
        <li>Die Autofahrer sehen damit nun noch schneller und einfacher via dem Absprung "Heute&amp;hier" ihren eigenen Vorfall</li>
        <li>Vorfälle, die vor mehr als einem Jahr dokumentiert wurden, werden öffentlich nur noch mit weniger Details und ohne Bild angezeigt</li>
        <li>Die gespeicherte Adressinformationen zu den Bildern kommt nun aus Maqquest und basiert auf Openstreetmap-Daten, damit diese dauerhaft gespeichert werden können (Copyright von Google Maps sehr stringent!)</li>
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
