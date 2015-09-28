<?php

/* @var $this yii\web\View */

use yii\helpers\Html;
use frontend\helpers\Assist;

$this->title = \Yii::t('base','About');
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    /*
        Otherwise when navigating to an anchor the heading is hidden behind the navbar
        See http://stackoverflow.com/questions/4086107/html-positionfixed-page-header-and-in-page-anchors
    */
    .site-about a[name]:before {
      content:"";
      display:block;
      height:50px; /* fixed header height*/
      margin:-50px 5px 0; /* negative fixed header height; it should be just a line so it does not overlap content and makes it unclickable */
    }
</style>
<div class="site-about">
    <h1><?= $this->title ?></h1>

    <p>
        Wenn Sie ganz schnell wissen wollen, wie die Sache funktioniert, dann schauen Sie sich am besten das <a href="#video">lustige Video</a> am Ende diese Seite an.
    </p>
    <h4>
        <a>Problem: Mißbräuchliches Parken auf Gehwegen, Radwegen oder in verkehrsberuhigten Zonen</a>
    </h4>
    <p>
        Das Problem des Gehwegparkens ist nach wie vor akut und leider wird es von offiziellen Stellen eher nicht ausreichend verfolgt
    </p>
    <p> 
        Obwohl es gemäß <?= Assist::extlink('StVO §12','http://dejure.org/gesetze/StVO/12.html') ?> in der Regel verboten ist. 
        Was aber viele Leute gar nicht wissen, sondern wie selbstverständlich lieber auf dem Gehweg parken als korrekt auf der Straße.
    </p>
    <p>
        Doch auf dieser Seite soll gar nicht versucht werden, dies genauer zu beleuchten, sondern nur auf andere relevante Seiten zu dem Thema verwiesen werden
    </p>
    <ul>
        <li><?= Assist::extlink('Offizielle Seite "gehwege-frei.de" des Fuß eV','//www.gehwege-frei.de') ?></li>
        <li><?= Assist::extlink('Initiative "Geh weg vom Gehweg" in Karlsruhe','//geh-weg-vom-gehweg.blogspot.de') ?></li>
        <li><?= Assist::extlink('Verkehrswende Darmstadt', '//verkehrswende-darmstadt.wikispaces.com/Gehwegparken') ?></li>
    </ul>
    <p>
        Dort kann sich jeder informieren, wie die rechtliche Lage aussieht ("<b>Verboten</b>, wenn nicht ausdrücklich durch Schild erlaubt!"), 
        wann Gehwegparken eventuell toleriert werden kann ("Bei <b>echter</b> Parknot und dann mit <b>mindestens</b> 1,20 m Restbreite auf dem Gehweg") und 
        wie teuer Verstöße sind ("Verwarnungsgeld von <b>20,- EUR bis 35,- EUR</b>").
    </p>
    <h4>
        <a>Hilfe zur Selbsthilfe</a>
    </h4>
    <p>
        Da Politik und die offiziellen Stellen das Problem nicht gelöst bekommen, will diese Plattform betroffenen Bürgern die Möglichkeit geben, sich zu wehren und den Finger auf die Wunde zu legen.
    </p>
    <p>
        In erster Linie durch <b>Dokumentation der Mißstände</b> und der leichten Möglichkeit, dann wieder und immer wieder bei den offiziellen Stellen nachzuhaken, warum der gut und öffentliche dokumentierte Mißstand nicht beseitigt wird.
    </p>
    <p>
        Aber in zweiter Linie soll es allen Betroffenen auch die Möglichkeit geben, das Problem durch <b>Privatanzeigen</b> anzugehen. Privatanzeigen sind eine Möglichkeit, die der Gesetzgeber ausdrücklich vorsieht, und in der Regel wird dadurch das Problem schnell gelöst. 
    </p>
    <p>
        Jeder kann dann für sich selbst entscheiden, welche der bereitgestellten Mittel er einsetzen möchte.
    </p>
    <h4>
        <a>Die Plattform "Parke nicht auf unseren Wegen"</a>
    </h4>
    <p>
        Die Plattform ist eine Webapplikation (<?= Assist::linkNew('Releasehistorie',['site/releasehistory']) ?>), die voll auf HTML5 und den damit verbundenen Möglichkeiten setzt. Die Webseiten sind hierbei 
        speziell für den Einsatz auf mobilen Geräten optimiert. Ältere Browser (vor allem nicht ältere Internet Exlorer!) werden als Konsequenz 
        nicht unterstützt und es wird ausdrücklich empfohlen, einen aktuellen und HTML5-kompatiblen Browser einzusetzen.
    </p>
    <p>
        Sollte es Probleme mit <b>aktuellen</b> Browsern geben, dann melden Sie diese bitte über die Kontaktseite.
    </p>
    <?php if (!Yii::$app->user->isGuest) : ?>
    <div class="col-sm-12 col-md-12 alert alert-warning">
        Das System ist derzeit noch in Entwicklung und es wird daher noch gewisse Nutzungseinschränkungen geben!
    </div>
    <?php endif ?>
    <h4>
        <a name="video">Video "Wie funktioniert es?"</a>
    </h4>
    <p>
        Damit Sie schneller verstehen wie die Sache funktioniert, haben wir ein kleines lustiges Video gedreht. Dort sehen Sie, wie
    </p>
    <ul>
        <li>
            Sie am auf dem Gehweg parkenden Auto einen "Parke-nicht-auf-unseren-Wegen"-Zettel anbringen (Zettel über <?= Assist::linkNew('Kontaktseite',['site/contact']) ?> bestellen),
        </li>
        <li>
            mit Ihrem Smartphone ein Photo machen (vorher GPS Tagging für Photos einstellen!),
        </li>
        <li>
            das Photo am besten gleich an Ort und Stelle auf die Webseite hochladen,
        </li>
        <li>
            der Moderator das Photo und die Texte freigibt (nur für neue/unbekannte Nutzer erforderlich),
        </li>
        <li>
            und der Autofahrer das Photo mit den Kommentaren beim Zurückkehren zum Auto über sein Smartphone (hat heute fast jeder ;-) direkt im Web sieht - und dann hofffentlich sein Verhalten ändert
        </li>
    </ul>
    <p>
        Das Video ist auf dem PC erstellt, aber es wurde eine Auflösung ähnlich wie auf dem Smartphone gewählt, damit Sie besser sehen, wie 
        gut die Sache mit dem Smartphone funktioniert. 
    </p>
    <p>
        Zum Betrachten des Videos auf einem Smartphone sollten Sie aber in den Vollbildmodus von Youtube wechseln, da es sonst deutlich zu klein wird.
    </p>
    <p>
        <iframe width="640" height="480" src="https://www.youtube.com/embed/RcmZpELZUB4?rel=0" frameborder="0" allowfullscreen></iframe>
    </p>
</div>
