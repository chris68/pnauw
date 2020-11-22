<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

// @chris68
use yii\helpers\Url;
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
        <a>Hauptproblem: Missbräuchliches Parken auf Gehwegen, Radwegen oder in verkehrsberuhigten Zonen</a>
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
        <li><?= Assist::extlink('Offizielle Seite "gehwege-frei.de" des Fuß eV','http://www.gehwege-frei.de') ?></li>
        <li><?= Assist::extlink('Initiative "Geh weg vom Gehweg" in Karlsruhe','https:/geh-weg-vom-gehweg.blogspot.de') ?></li>
        <li><?= Assist::extlink('Verkehrswende Darmstadt', 'http://www.verkehrswende-darmstadt.de/aktionen/illegales-gehwegparken') ?></li>
        <li><?= Assist::extlink('Bußgeldkatalog "Parken auf dem Gehweg"','https://www.bussgeldkatalog.org/halten-parken/auf-dem-gehweg') ?></li>
        <li><?= Assist::extlink('Verfahren bei Privatanzeigen','https://geh-weg-vom-gehweg.blogspot.de/p/orecht.html') ?></li>
    </ul>
    <p>
        Dort kann sich jeder informieren, wie die rechtliche Lage aussieht ("<b>Verboten</b>, wenn nicht ausdrücklich durch Schild erlaubt!"), 
        wann Gehwegparken eventuell toleriert werden kann ("Bei <b>echter</b> Parknot und dann mit <b>mindestens</b> 1,20 m Restbreite auf dem Gehweg") und 
        wie teuer Verstöße sind ("Verwarnungsgeld von <b>20,- EUR bis 35,- EUR</b>").
    </p>
    <p>
       Wir haben die Zusammenhänge zudem in unserem <?= Assist::extlink('Standardhinweiszettel "Parke nicht auf unseren Wegen"', 'https://parke-nicht-auf-unseren-wegen.de/f/pnauw') ?> zusammengefasst,
       auch damit es neue Nutzer leichter haben, sich eigene Zettel mit dieser Kopiervorlage zu erstellen.
    </p>

    <h4>
        <a>Hilfe zur Selbsthilfe</a>
    </h4>
    <p>
        Da Politik und die offiziellen Stellen das Problem nicht gelöst bekommen, will diese Plattform betroffenen Bürgern die Möglichkeit geben, sich zu wehren und den Finger auf die Wunde zu legen.
    </p>
    <p>
        In <b>erster Linie</b> durch <b>Dokumentation der Missstände</b> und der leichten Möglichkeit, dann wieder und immer wieder bei den offiziellen Stellen nachzuhaken, warum der gut und öffentliche dokumentierte Missstand nicht beseitigt wird.
    </p>
    <p>
        Aber in <b>zweiter Linie</b> soll es allen Betroffenen auch die Möglichkeit geben, das Problem durch <b>Privatanzeigen</b> anzugehen. Privatanzeigen sind eine Möglichkeit, die der Gesetzgeber ausdrücklich vorsieht, und in der Regel wird dadurch das Problem schnell gelöst.
        Die notwendige Dokumentation hierfür lässt sich über die Plattform ganz schnell als PDF erstellen, indem man die Druckansicht im Browser druckt/Als PDF speichert (findet sich in Android unter <i>Teilen</i>). <b>Auch ohne Anmelden und damit ganz anonyom!</b>
    </p>
    <p>
        Jeder kann dann für sich selbst entscheiden, welches der beiden bereitgestellten Mittel er einsetzen möchte. <b>Tatsache ist übrigens, dass die meisten Nutzer sich direkt für den Weg einer Anzeige ohne Öffentlichkeit entscheiden.</b>
        Anscheinend merken Sie, dass bei Gehwegparken eigentlich nur Anzeigen und Verwarnungsgelder wirken. Und mit dieser Plattform ist ja auch sehr gut sichergestellt, dass die Anzeige von den Ämtern gewürdigt wird, weil alle rechtlichen Voraussetzungen
        (Papierform, eindeutige Beweismittel, etc.) 100% erfüllt sind. 
    </p>
    <h4>
        <a>Nebenschauplatz: Verkehrschilder und die Ignoranz der Behörden für die Belange von Fußgängern und Radfahren</a>
    </h4>
    <p>
        Parallel zu dem Hauptproblem, der Tolerierung des Gehwegparkens, gibt es aber auch immer wieder <?= Assist::linkNew('Verkehrszeichen',['https://de.wikipedia.org/wiki/Verkehrszeichen']) ?> (also Verkehrsschilder, aber auch Markierungen auf 
        der Straße!), die den Belangen von Fußgängern und Radfahrern nicht gerecht werden. Der Klassiker ist das Aussperren von Radfahrern auf Wirtschafts- oder Waldwegen,
        wo hierfür keinerlei Notwendigkeit besteht, sondern meist der Bauhof oder die Behörde einfach nur das falsche Schild genommen haben. Es kann aber auch eine
        Freigabe von Gehwegparken sein an Stellen, wo es dadurch einfach zu eng wird für die Fußgänger und Kleinkinder auf dem Fahrrad. Oder die Einrichtung eines Radwegs mit 
        Benutzungspflicht vs. der Freigabe für Radfahrer (Zusatz "Radfahrer frei").
    </p>
    <p>
        Es gibt Städte und Gemeinden, wo man solche Sachen einfach im Internet oder per App melden kann und es dann überlicherweise auch korrigiert wird. 
        Aber nicht alle Städte und Gemeinden haben hier moderne Mittel, um sowas schnell und effizient zu melden. 
        Und es gibt leider auch immer wieder Städte und Gemeinden, wo eine solche Meldung einfach nicht beantwortet wird oder auf Widerstände stößt, entweder aus Ignoranz oder Überlastung. 
        Es gibt hier dann bei Mißerfolg einer solchen reinen Mitteilung zwei Möglichkeiten, 
        einen Antrag auf Neuverbescheidung und einen Widerspruch gemäß  <?= Assist::linkNew('§70 VwGO',['https://dejure.org/gesetze/VwGO/70.html']) ?>.
        Der Antrag auf Neuverbescheidung sollte kostenlos sein und damit für normale Bürger der Weg der Wahl, der Widerspruch ist ein offizieller Akt, der durchaus in 
        nicht unerheblichen Kosten münden kann und sollte daher nur von rechtskundigen Bürgern beschritten werden. Manchmal wirkt aber halt nur der zweite Weg.
    </p>
    <p>
        Die Plattform unterstützt alle Wege durch entsprechende Vorfälle (Kategorie "Sonstiges") und die Möglichkeit, die Verkehrszeichen mit Ort und Kommentar schnell als PDF auszudrucken für einen Emailversand.
        Diese sehr generischen Möglichkeiten können übrigens auch für ganz andere Zwecke genutzt werden, z.B. für Wanderzeichen, Müll auf der Straße oder was auch immer, wo ein Bild mit einem Ort
        und ein schönes PDF hilft.
    </p>
    <h4>
        <a>Die Plattform "Parke nicht auf unseren Wegen"</a>
    </h4>
    <p>
        Die Plattform ist eine Webapplikation (<?= Assist::linkNew('Releasehistorie',['site/releasehistory']) ?>), die voll auf HTML5 und den damit verbundenen Möglichkeiten setzt. Die Webseiten sind hierbei 
        speziell für den Einsatz auf mobilen Geräten optimiert und funktionieren besser als so manche "richtige" App. Ältere Browser (vor allem nicht ältere Internet Exlorer!) werden als Konsequenz
        nicht unterstützt und es wird ausdrücklich empfohlen, einen aktuellen und HTML5-kompatiblen Browser einzusetzen.
    </p>
    <p>
        Sollte es Probleme mit <b>aktuellen</b> Browsern geben, dann melden Sie diese bitte über die Kontaktseite.
    </p>
    <h4>
        <a name="video">Video "Wie funktioniert es?"</a>
    </h4>
    <p>
        Damit Sie schneller verstehen wie die Sache funktioniert, haben wir ein kleines lustiges Video gedreht. Dort sehen Sie, wie
    </p>
    <ul>
        <li>
            Sie am auf dem Gehweg parkenden Auto einen "Parke-nicht-auf-unseren-Wegen"-Zettel anbringen (gedruckte Zettel entweder über <?= Assist::linkNew('Kontaktseite',['site/contact']) ?> bestellen oder nutzen Sie unseren <?=Assist::help('Zettelassistenten', 'flyer')?>),
        </li>
        <li>
            mit Ihrem Smartphone den Vorfall aufnehmen, am besten inklusive Photo,
        </li>
        <li>
            der Moderator das Photo und die Texte freigibt (nur für neue/unbekannte Nutzer erforderlich),
        </li>
        <li>
            und der Autofahrer das Photo mit den Kommentaren beim Zurückkehren zum Auto über sein Smartphone (hat heute fast jeder ;-) direkt im Web sieht - und dann hofffentlich sein Verhalten ändert
        </li>
    </ul>
    <p>
        Zum Betrachten des Videos auf einem Smartphone sollten Sie in den Vollbildmodus von Youtube wechseln. Das Video zeigt übrigens einen veralteten Releasestand - neuerdings ist es deutlich leichter.
    </p>
    <p>
        <iframe width="640" height="480" src="https://www.youtube.com/embed/RcmZpELZUB4?rel=0&hl=de&cc_lang_pref=de&cc_load_policy=1"  frameborder="0" allowfullscreen></iframe>
    </p>
    <h4>
        <a name="disqus_thread">Diskussionen</a>
    </h4>
    <p>
        Wenn Sie etwas generell zur Plattform kommentieren wollen, dann können Sie das gerne hier unten tun. Konkrete Vorfälle bzw. Kampagnen sollten Sie hingegen lieber direkt am Vorfall bzw. bei der Kampagne kommentieren.
    </p>
    <div id="disqus_thread"></div>
    <script type="text/javascript">
        /* * * CONFIGURATION VARIABLES * * */
        var disqus_shortname = 'pnauw';
        var disqus_identifier = '/site/about';
        var disqus_url = '<?= Url::to(['site/about'],true)?>';
        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>

</div>
