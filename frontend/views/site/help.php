<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\helpers\Assist;

$this->title = 'Hilfe';
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
        Die Hilfefunktion ist kontextsensitiv. Wenn Sie in einer bestimmten Maske sind und dann oben auf Hilfe klicken, wird direkt zu dem entsprechenden Hilfetext navigiert.
        Daher wird die Hilfe auch immer in einem neuen Fenster/Reiter geöffnet, damit auf keinen Fall irgendwelche offenen Bearbeitungen verloren gehen.
    </p>
    <h2><a name="picture">Bilder</a></h2>
    <h3><a name="picture-general">Generell</a></h3>
    <p>
        Als Bilder sind ausschließlich JPEG-Dateien erlaubt. Die Bilder werden nach dem Hochladen folgendermaßen verarbeitet
    </p>
    <ol>
        <li>Das Bild wird gemäß der EXIF-Ausrichtung gedreht</li>
        <li>Das Originalbild wird auf eine sinnvolle Auflösung reduziert, aber ansonsten ohne weitere Änderungen abgespeichert. <b>Es ist so aber nur für den Eigner sichtbar!</b></li>
        <li>Es werden dann Verkleinerungen in der Größe Thumbnail, Small und Medium generiert. <b>Auch diese sind nur für den Eigner sichtbar!</b></li>
        <li>Die Verkleinerungen werden dann in einer zweiten Version verschwommen abgespeichert. <b>Nur diese Versionen sind für die Öffentlichkeit bestimmt!</b></li>
        <li>Bei allen Verkleinerungen werden alle EXIF-Parameter gelöscht - es ist also keine Kamerakennung etc. mehr erkennbar</li>
        <li>Vorher wird noch das Aufnahmedatum und eventuell vorhandene GEO-Koordinaten aus den Bilder ausgelesen und gespeichert.</li>
    </ol>
    <h3><a name="picture-capture">Bilder aufnehmen</a></h3>
    <p>
        Bei den meisten Kameras in Smartphone können Sie direkt aus dem Browser heraus ein Bild aufnehmen, dass dann gleich hochgeladen wird.
        Damit Sie nicht unnötig Bandbreite vergeuden, sollte Sie die Kamera auf z.B. nur 0.3 MB große Bilder einstellen - das reicht vollkommen.
        Die Karte unten zeigt Ihnen den derzeitigen Standort als blauen Kreis an. Hierzu müssen Sie natürlich im Brower akzeptieren, dass wir diesen Standort ermitteln können.
    </p>
    <p>
        In der Regel funktioniert dieses direkte Aufnehmen dann auch recht gut, aber leider kann es bei der Übernahme in den Webbrowser Probleme geben. In diesem Fall müssen Sie das normale Hochladen aus dem Order, wo in dem Smartphone die Bilder abgespeichert sind, nutzen.
    </p>
    <h3><a name="picture-guestcapture">Bilder aufnehmen (Gastzugang)</a></h3>
    <p>
        Es besteht auch die Möglichkeit, Bilder als <a href="#user-level-anonymous">anonymer Nutzer</a> aufzunehmen und hochzuladen.
    </p>
    <p>
        Sie müssen dann jedoch unbedingt daran denken, das Bild auch gleich zu bearbeiten und eine Veröffentlichung zu beantragen. 
        Ansonsten bringt es wenig!
    </p>
    <h3><a name="picture-upload">Bilder hochladen</a></h3>
    <p>
        Das Hochladen von einem oder mehreren Bildern aus einem Ordner ist ebenso möglich. Wenn die Bilder im Original sehr groß sind, dann sollten Sie diese voher 
        entsprechend verkleinern, denn durch das Hochladen unnötig großer Bilder wird die Last für unseren Server sehr hoch. Zudem wird die Auflösung der Bilder nach dem Hochladen sowieso reduziert.
    </p>
    <p>
        Wenn Sie sehr, sehr viele Bilder hochladen, dann sollten Sie die Bilder am besten von 1 ab durchnumerieren bzw. irgendwie sortieren, damit Sie nicht durcheinander kommen. 
        Es werden daher auch immer das erste und das letzte hochgeladene Bild nach dem Hochladen nochmal angezeigt, damit Sie wissen, wo Sie gerade stehen.
    </p>
    <p>
        Sie können in dem aufklappbaren Bereich Vorgabewerte (z.B. Vorfall 'Gehwegparken', Aktion 'Zettel angehängt') für die hochgeladenen Bilder setzen, um die Verfälle schneller zu klassifizieren.         
        Hierbei werden jedoch bereits in den Bilder enthaltene Geokoordinaten sinnigerweise nie überschrieben, sondern es wird maximal eine textuelle Ortangabe übernommen (z.B. 'Berlin, Deutschland').
    </p>
    <h3><a name="picture-guestupload">Bilder hochladen (Gastzugang) </a></h3>
    <p>
        Auch das Hochladen von Bildern ist als <a href="#user-level-anonymous">anonymer Nutzer</a> möglich. Aber auch hier bitte daran denken, die Beantragung der Veröffentlichung der Bilder nicht zu vergessen!
    </p>
    <h3><a name="picture-create">Vorfall ohne Bild anlegen</a></h3>
    <p>
        Manchmal gibt es Situationen, wo Sie gerade keine Kamera haben bzw. kein gutes Bild machen können (z.B. Nachts). Dann können Sie trotzdem einen Vorfall ohne Bild anlegen. Der Vorfall wird dann jedoch automatisch und nicht änderbar auf den Zeitpunkt der Anlage datiert.
    </p>
    <h3><a name="picture-serverupload">Bilder von FTP übernehmen</a></h3>
    <p>
        Sie können hier Bilder über einen anonymen FTP-Zugriff auf den Server hochladen (Zugang: ftp parke-nicht-auf-unseren-wegen.de, User: 'ftp', Passwort: leer, Verzeichnis: 'upload/<i>&lt;Ihr jeweiliger Login/Nutzername&gt;</i>'). 
        Der Clou ist hierbei, dass man die Bilder direkt von Mobiltelefon übermitteln kann, wenn man eine Software wie z.B. 
        <?=    Assist::extlink('JustResizeIt for Android', 'http://justresizeit.com/mobile') ?> oder <?=    Assist::extlink('FTP Picture Upload for Apple', 'https://itunes.apple.com/de/app/ftp-picture-upload/id302286413?mt=8') ?> einsetzt. 
    </p>
    <p>
        Mit diesen Apps kann man die Bilder direkt aus der Bildergallery auswählen und mit 2-3 Clicks an den Server übermitteln. Es besteht sogar die Möglichkeit, die Bilder vorher
        zu verkleinern, wodurch das Hochladen deutlich schneller wird und man entsprechend weniger Datenvolumen verbraucht 
        (Hinweis für JustResizeIt: derzeit geht leider beim Verkleinern die EXIF-Informationen mit den GPS-Infos verloren, aber das soll in einer 
        zukünftigen Version wahrscheinlich bis Ende 2014 gefixt werden).
    </p>
    <p>
        Diese Bilder können dann über die Funktion übernommen werden und stehen danach zur Verfügung wie wenn man diese direkt aus dem Dateisystem des Rechners oder Mobiltelefons hochgeladen 
        hätte. Es ist halt nur wesentlich schneller und einfacher und vor allem bei Vor-Ort-Einsätzen sehr nützlich. Ansonsten funktioniert die Funktion
        aber wie das normale <a href="#picture-upload">Hochladen von Bildern</a>
        
    </p>
    <p>
        Die Funktion steht jedoch nur dafür freigeschalteten <a href="#user-level-trusted">vertrauenswürdigen Nutzern</a> zur Verfügung. Wenn Sie interessiert sind, dann
        kontaktieren Sie uns bitte über die <a href="<?= Url::to(['contact']) ?>">Kontaktmöglichkeit</a> unter Angabe ihres Nutzernamens.
    </p>
    <h3><a name="picture-manage">Bilder bearbeiten</a></h3>
    <p>
        Nach dem Hochladen müssen Sie die Bilder bearbeiten. Es gibt hierzu eine Mehrfachbearbeitung, wo Sie immer mehrere Bilder gleichzeitig bearbeiten können und eine Einzelbearbeitung, wo Sie jeweils nur ein einzelnes Bild bearbeiten.
    </p>
    <p>
        Die Mehrfachbearbeitung ist vor allem für große Kampagnen gedacht, wo Sie sehr, sehr viele Bilder schnell klassifzieren wollen, aber keine großen Detailinfos (wie z.B. Autonummern) eingeben wollen. Die Masken sind daher für diesen Zweck sehr effizient aufgebaut.
        So ist zum Beispiel die Tabulatorreihenfolge so optimiert, dass Sie über das Feld <em>Vorfall</em> sehr schnell durchspringen können. Auch die Auswahllisten sind so intelligent 
        aufgebaut, dass Sie mit Buchstaben wie 'G' schnell und leicht den korrekten Verfall wählen können.
    </p>
    <p>
        Einen Nachteil hat die Mehrfachbearbeitung - <b>eventuelle Eingabefehler werden nicht detailliert angezeigt, sondern der Satz wird einfach nicht gespeichert und die Änderungen gehen verloren!</b>
        In der Regel kein Problem, weil man über die Felder in der Mehrfachbearbeitung so gut wie nie Eingabefehler erzeugen kann. Die Ausnahmen sind unter <a href='#picture-consistency'>Konsistenzprüfungen</a> erläutert.
    </p>
    <h3><a name="picture-update">Bilder detailliert bearbeiten</a></h3>
    <p>
        Bei der Einzelbearbeitung ist die Maske hingegen auf mehrere Reiter aufgeteilt, wo in jedem Reiter ein Themengebiet abgedeckt ist.
    </p>
    <h4><a name="picture-update-imagetab">Reiter "Bild &amp; Kfz-/Vorfallsdaten"</a></h4>
    <p>
        In dem Reiter können Sie durch Klicken auf das Bild und den Ziehen des Zoom-Reglers sich das Kennzeichen genau rauszoomen. Das hilft beim Erfassen und das Detailbild kommt dann auch automatisch auf eine potentielle <a href='#citation'>Anzeige</a>.
    </p>
    <p>
        Die restlichen Felder erklären sich von selbst. Die Zuweisung zu einer Anzeige wird NIE öffentlich sein.
        Wenn Sie jedoch als Maßnahme 'Anzeige' dokumentieren, dann machen Sie dadurch bewußt öffentlich, dass Sie eine Anzeige gestellt haben.
        Es ist Ihre Entscheidung, wie Sie es machen wollen - eher offen und damit eventuell abschreckend oder eher nur verdeckt.
    </p>
    <h4><a name="picture-update-maptab">Reiter "Karte &amp; Ortsdaten"</a></h4>
    <p>
        In dem Reiter kann Sie die Originalposition der Aufnahme sehen (blauer Pfeil) und die korrigierte Position (roter Pfeil; wird ohne Korrektur den blauen Pfeil verdecken!). Wenn das Bild keine GPS-Koordinaten erhalten hatte, dann wurde es auf die GPS-Position (0,0) am Äquator gesetzt.
        Generell können Sie eine neue Position durck Klicken auf die Karte setzen. Die Karte wird dann automatisch auf die neue Position zentriert und es wird auch reingezoomt (da es so meist schneller geht!).
    </p>
    <p>
        Für die jeweilige relevante Position wird dann über den Google Maps Service die nächstliegende Adresse ermittelt. Diese wird dann auch für eine gewisse Zeit (ca. 3 Monate) zwischengespeichert, damit wir das nicht immer wieder neu ermitteln müssen (Caching). 
    </p>
    <p>
        Zudem besteht über die Kartensuche auch die Möglichkeit, wie von Google gewohnt in der Karte nach Straßen, etc. zu suchen. Damit das schneller geht, ist das Feld bereits vorbelegt mit der aktuellen Adresse.
    </p>

    <h4><a name="picture-update-datatab">Reiter "Grunddaten"</a></h4>
    <p>
        In dem Reiter können Sie die Grunddaten setzen. Bei vielen Bildern werden Sie das in der Regel aber in der Mehrfachverarbeitung machen, denn dort geht es deutlich schneller!
    </p>
    <h4><a name="picture-update-overviewtab">Reiter "Übersicht"</a></h4>
    <p>
        In dem Reiter können Sie alle Daten genau tabellarisch sehen. Ändern können Sie hier jedoch nichts.
    </p>
    <h3><a name="picture-massupdate">Mehrere Bilder detailliert bearbeiten</a></h3>
    <p>
        Hier haben Sie die Möglichkeit, eine Auswahl von mehreren Bildern nacheinander detailliert zu bearbeiten. 
        Sie können oben durch die Bilder durchnavigieren und das aktuelle Bild unten wie gewohnt im Detail bearbeiten.
    </p>
    <p>
        Dies ist vor allem dann hilfreich, wenn Sie z.B. als für die Auswahl einen Filter setzen wie <em>Vorfall = leer</em>, weil dann nach dem Setzen des Vorfalls das Bild automatisch aus der Auswahl verschwindet. 
        Dadurch können Sie sehr effizient einen Arbeitsvorat abarbeiten.
    </p>
    <h3><a name="picture-publish">Bilder veröffentlichen</a></h3>
    <p>
        Wenn Sie die Bilder bearbeitet haben, dann müssen Sie diese noch veröffentlichen. Sie können zwar das entsprechende Feld <em>Sichtbarkeit</em> auch in fast allen Masken direkt setzen, aber bei vielen Bildern hat es sich bewährt, es auf einem Rutsch und ganz am Ende zu machen.
    </p>
    <p>
        Wenn Sie bereits ein <a href="#user-level-trusted">vertrauenswürdiger Nutzer</a> sind, dann können Sie direkt veröffentlichen.
    </p>
    <p>
        Ansonsten müssen Sie die Veröffentlichung beantragen und in der Regel wird ein <a href="#user-level-moderator">Moderator</a> dies auch zeitnah freigeben.
        Sollte der Moderator nicht einverstanden sein, wird er die Veröffentlichung ablehnen.
        Übrigens sieht selbst der Moderator nur die verschwommenen Bilder - die unverschwommenen Bilder sehen immer nur Sie selbst!
    </p>

    <h3><a name="picture-index">Bilder betrachten</a></h3>
    <p>
        Hier können Sie die eingestellten Bilder betrachten. Die Bilder sind natürlich alle so verschwommen, dass man Autonummern, konkrete Personen, etc. nicht erkennen kann. Die Seite ist wie folgt aufgebaut:
    </p>
    <ul>
    <li>Oben gibt es eine aufklappbare Sektion <a href='#picture-search'>Suchen &amp; Filtern</a>, wo Sie sehr umfangreich einstellen können, welche Bilder Sie sehen wollen</li>
    <li>Dann kommt eine <a href='#picture-quicksearch'>Schnellsuche</a>, mit der Sie wichtige und generelle Filter-/Sucheinstellungen vornehmen können.</li>
    <li>Darunter haben Sie immer die <a href='#picture-overviewmap'>Übersichtskarte</a>, mit der man schnell sehen kann, wo viele Verfälle sind. Zudem kann man über die Übersichtskarte den Suchbereich einschränken</li>
    <li>Dann kommen Links mit kontextsensitiven Absprüngen auf weitere Funktionen</li>
    <li>Und nicht zuletzt kommen am Ende natürlich die Bilder selbst und Sie können mit der Seitennavigation sich durchblättern</li>
    </ul>
    
    <h3><a name="picture-view">Einzelbild betrachten</a></h3>
    <p>
        Hier kann man ein einzelnes Bild mit allen öffentlichen Details betrachten und sieht dann auf der Karte, wo genau der Vorfall war.
    </p>
    
    <h3><a name="picture-overviewmap">Übersichtskarte</a></h3>
    <p>
        Auf der Übersichtskarte werden die durch die Sucheinstellung derzeit selektierten Vorfälle als Punkte angezeigt. Je mehr Verfälle in einen Bereich sind und je schwerwiegender die Vorfälle sind, desto roter wird der Bereich.
        Über die Übersichtskarte kann zudem die Suche eingeschränkt werden, wenn dies durch die Option <em>Ausschnitt <b>begrenzt</b> Suchergebnisse</em> so vorgegeben ist. Andernfalls (<em>Ausschnitt <b>gemäß</b> Suchergebnisse</em>) ermittelt sich die Größe/Ausschnitt der Übersichtskarte automatisch
        basierend auf den Suchergebnissen. Wenn man die Übersichtskarte auf eine bestimmte Stelle haben will, kann man das oben über die Suchezeile wie von Google Maps gewohnt tun.
    </p>
    <p>
        Bei den Sucheinstellungen kann zudem angegeben werden, ob man die Punkte nur für den aktuellen Kartenausschnitt berechnet haben will oder auch über den Ausschnitt hinaus (Option <em>Auch Ermittlung der Übersichtskarte auf den Kartenbereich beschränken</em>).
        Der Vorteil bei der Ermittlung über den Ausschnitt hinaus ist, dass man leichter die Karte verschieben kann und trotzdem noch Punkte bekommt. Der Vorteil bei der Beschränkung ist, dass die Intensität der Farbgebung sich nur auf den Ausschnitt bezieht und man dadurch nicht durch benachbarte Gebiete mit hoher Intensität runtergestuft wird.
        Am besten einfach mal rumspielen, um den Unterschied zu erkennen!
    </p>
    
    <h3><a name="picture-search">Suche und Filtern</a></h3>
    <p>
        In dem aufklappbaren Detailbereich sieht man oben vor allem die Einstellungen bezüglich der Karte (siehe <a href='#picture-overviewmap'>Übersichtskarte</a>) und den gewünschten Zeitraum.
    </p>
    <p>
        Darunter sind weitere Suchoptionen, die aber eigentlich alle selbsterklärend sind. Folgende generelle Festlegungen:
    </p>
    <ul>
        <li>Bei Datumsfeldern muss das Datum in der Form jjjj-mm-tt eingegeben werden; es gibt aber immer auch einen Datumselektor</li>
        <li>Bei den Auswahlboxen kann man teilweise immer nur eine und teilweise auch mehrere Optionen wählen - einfach ausprobieren</li>
        <li>Die Suche in den Textfeldern ist eine Teiltextsuche, bei der zwischen Groß- und Kleinschreibung unterschieden wird. Eine Suche nach <i>straße</i> findet also <i>Kriegsstraße</i>, aber nicht <i>Straße des 17.Juni</i></li>
    </ul>
    
    <h3><a name="picture-quicksearch">Schnellsuche</a></h3>
    <p>
        Über die Schnellsuche kann man leicht häufig benötigte Sucheeinstellungen schneller durchführen und muss damit nicht immer in die detaillierte Suche. Zudem kann man die Karte auf seinen derzeitigen Standort setzen, wenn die die mobile Einheit unterstützt.
    </p>
    <p>
        Mit den beiden Buttons rechts kann man einerseits die Suchergebnisse löschen und andererseits die Suchergebnisse aktualisieren.
    </p>
    
    <h3><a name="picture-consistency">Konsistenzprüfungen</a></h3>
    <p>
        Wenn Sie Bilder bearbeiten prüft das System vor dem Aktualisieren die Konsistenz. Folgende Prüfungen sind hierbei primär zu nennen:
    </p>
    <ul>
        <li>Sie können nur als <a href="#user-level-trusted">vertrauenswürdiger Nutzer</a> direkt Bilder veröffentlichen. Als normaler Nutzer müssen Sie die Veröffentlichung beantragen.</li>
        <li>Sie müssen für alle Bilder einen genauen Aufnahmeort angeben. Wenn ihre Kamera das automatische Erfassen von GPS-Koordinaten unterstützt, dann werden Sie hier nie Probleme haben. Aber in allen anderen Fällen müssen Sie es manuell in dem <a href="#picture-update-maptab">Reiter "Karte &amp; Ortsdaten"</a> der Einzelbearbeitung angeben.</li>
    </ul>
    <p>
        Wenn Sie ein Bild einzeln bearbeiten, werden Ihnen die verletzten Konsistenzpüfungen auch immer genau genannt. Nur in der Mehrfachbearbeitung kann dies leider immer nur summarisch genannt werden (= Anzahl der Bilder wo es geklappt hat bzw. eben nicht geklappt hat und <b>die gemachten Änderungen dann einfach verworfen wurden</b>). Im Zweifel müssen Sie hier dann immer in die Einzelbearbeitung gehen, um herauszufinden, was das genaue Problem ist.
    </p>
    
    <h3><a name="picture-moderate">Bilder moderieren</a></h3>
    <p>
        Das Moderieren läuft generell genauso ab wie das <a href="#picture-publish">Veröffentlichen</a>. Der einzige Unterschied ist, dass es eben nur ein <a href="#user-level-moderator">Moderator</a> machen kann und er dies dann für Bilder anderer Leute machen darf.
    </p>

    <h2><a name="campaign">Kampagnen &amp; Hotspots</a></h2>
    <p>
        Kampagnen und Hotspots sind die beiden Seiten der gleichen Medaille: wenn man einen Hotspot hat, wo extrem störend auf den Gehwegparken geparkt wird, wird man in der Regel eine Kampagne starten, um das Problem anzugehen. Und eine Kampagne wird man in der Regel nur dann starten, wenn man auch einen Hotspot hat.
    </p>
    <p>
        Es besteht dann die Möglichkeit, Verfälle einer solchen Kampagne/Hotspot zuzuordnen und man kann auch danach filtern/suchen. Dadurch wird es dann deutlich leichter, den Autofahrern klarzumachen, wo das Problem liegt und wie eventuell die Konsequenzen sind.
    </p>
    
    <h3><a name="campaign-crud">Verwalten von Kampagnen &amp; Hotspots </a></h2>
    <p>
        Das Verwalten von <a href='#campaign'>Kampagnen bzw. Hotspots</a> geschieht in einigen zusammenhängenden Masken, wo Sie ihre Kampagnen/Hotspots sehen, neue anlegen, existierende bearbeiten und löschen können. Die Masken sollten eigentlich selbst erklärend sein.
    </p>
    
    <h3><a name="campaign-show">Öffentliche Darstellung von Kampagnen &amp; Hotspots </a></h2>
    <p>
        Hier sehen Sie die öffentliche Darstellung zu <a href='#campaign'>einer Kampagne bzw. einem Hotspot</a>. Diese Inhalte wurden von einem Nutzer eingestellt, um klarer zu dokumentieren, warum er sich konkret an dem Gehwegparken stört und was er eventuell gedenkt, dagegen zu unternehmen.
    </p>
    
    <h2><a name="citation">Anzeigen &amp; Beschwerden</a></h2>
    <p>
        Anzeigen bzw. Beschwerden sind wahrscheinlich die einzigen Möglichkeiten, die Sie haben, wenn eine <a href='#campaign'>Kampagne</a> alleine nicht ausreichend Wirkung zeigt.
    </p>
    <p>
        Eine Beschwerde ist hierbei eine nette Zusammenfassung von vielen Falschparkern zum Ausdrucken oder Versand als PDF-Datei an die Polizei oder das Ordnungsamt. Eine Beschwerde ist rechtlich unverbindlich und Sie können auch darum bitten, das Ihr Name nicht öffentlich genannt wird. 
        Die Hoffnung einer solchen Beschwerde ist, dass die Behörde die nicht tolerierbare Lage erkennt und dann entsprechend selbst tätig wird.
    </p>
    <p>
        Wenn das nicht reicht oder Sie bereits wissen, dass nie was passiert, dann können Sie eine rechtsverbindliche Privatanzeige stellen. Hier müssen Sie die Sache meist ausdrucken, unterschreiben und in der Regel auch eine Kopie ihres Ausweises hinzufügen. Denn Sie werden dann als Zeuge 
        genannt und für den betroffenen Halter des angezeigten Fahrzeugs wird dies auch erkenntlich sein. Darüber sollten Sie sich auf jeden Fall im Klaren sein. Die Anzeigen werden in der Regel dann auch umgesetzt, weil wir (zumindest in Deutschland) immer noch in einem Rechtsstaat leben.
    </p>
    
    <h3><a name="citation-crud">Verwalten von Anzeigen &amp; Beschwerden</a></h2>
    <p>
        Das Verwalten von <a href='#citation'>Anzeigen bzw. Beschwerden</a> geschieht in einigen zusammenhängenden Masken, wo Sie ihre Anzeigen/Beschwerden sehen, neue anlegen, existierende bearbeiten und löschen können. Die Masken sollten eigentlich selbst erklärend sein.
    </p>
    
    <h2><a name="general">Generelles</a></h2>
    <h3><a name="right-to-be-forgotten">Recht auf Vergessenwerden</a></h3>
    <p>
        Die Plattform ist für aktuelle Kampagnen gegen das Gehwegparken gedacht und hier braucht es leider die Möglichkeit, die Autos auf dem Gehweg auch mal zu zeigen, um ein Undenken zu bewirken.
        Aber es gibt auch ein <?= Assist::extlink('Recht auf Vergessenwerden', 'http://de.wikipedia.org/wiki/Recht_auf_Vergessenwerden') ?> und bei uns soll dies nach einem Jahr sein. 
    </p>
    <p>
        Daher werden alle Vorfälle, die vor mehr als ein Jahr in der Plattform dokumentiert wurden, öffentlich nur noch deutlich weniger detailliert und vor allem ohne Bild angezeigt. Nur der Eigner der Bilder kann diese weiterhin
        einsehen, denn eine physikalische Löschung wird erst nach weiteren Jahren durchgeführt.
    </p>
    <p>
        Was jedoch bleibt sind die roten Punkte in der Übersichtskarte, denn für eine historische Betrachtung von Kampagnen (und deren Erfolg oder Mißerfolg) sind diese Informationen zu wertvoll.
    </p>
    <h3><a name="markdown-syntax">Markdown Syntax</a></h3>
    <p>
        Bei Webapplikationen will man seine eingestellten Inhalte möglichst schön formatieren. Hier kann man mit HTML zwar alles machen, aber HTML ist meist zu kompliziert und es wäre zudem gefährlich, den Nutzer HTML direkt ein-/ausgeben zu lassen
    </p>
    <p>
        Und daher haben sich kluge Köpfe eine spezielle Syntax überlegt, mit der man solche Formatierungen machen kann: die <?=    Assist::extlink('Markdown Syntax', 'http://de.wikipedia.org/wiki/Markdown') ?>.
        Wenn Sie sich den <?=    Assist::extlink('Artikel in Wikipedia', 'http://de.wikipedia.org/wiki/Markdown') ?> durchlesen, dann werden Sie es schnell verstehen und leicht nutzen können.
    </p>
    <p>
        Und das beste ist: Sie haben sogar einen kleinen Editor, der Sie dabei unterstützt. Den Editor haben wir hierbei nicht selbst geschrieben, sondern <?=    Assist::extlink('Kartik Visweswaran', 'http://kartikv.krajee.com') ?> hat ihn freundlicherweise <?=    Assist::extlink('Public Domain', 'http://de.wikipedia.org/wiki/Gemeinfreiheit') ?> zur Verfügung gestellt.
    </p>
    <h3><a name="user-level">Berechtigungsstufen</a></h3>
    <p>
        Als Nutzer in dem System können Sie folgende unterschiedliche Berechtigungsstufen haben.
    </p>
    <h4><a name="user-level-anonymous">Anonymer Nutzer / Gastzugang</a></h4>
    <p>
        Wenn Sie ohne eine Anmeldung arbeiten, dann sind Sie ein anonymer Nutzer und arbeiten im Gastzugang. Sie können dann Bilder hochladen und auch die Veröffentlichung beantragen. Aber Sie kommen später nie wieder an die Bilder dran. Daher sollten Sie sich bei einer regelmäßigen Nutzung registrieren.
    </p>
    <h4><a name="user-level-normal">Normaler Nutzer</a></h4>
    <p>
        Nachdem Sie sich registiert haben, sind Sie erst einmal ein normaler Nutzer, der noch eingeschränkte Rechte hat. Sie können keine Kampagnen anlegen und alle ihre hochgeladenen Bilder bzw. anderen Beiträge müssen moderiert/freigegeben werden.
    </p>
    <h4><a name="user-level-trusted">Vertrauenswürdiger Nutzer</a></h4>
    <p>
        Wenn Sie einige Bilder hochgeladen haben und schon eine gewisse Zeit tätig sind, dann können Sie beantragen, als <em>vertrauenswürdiger Nutzer</em> eingestuft zu werden.
    </p>
    <p>
        Beantragen Sie dies bitte über die <a href="<?= Url::to(['contact']) ?>">Kontaktmöglichkeit</a> unter Angabe Ihrer Anmeldadresse. Ein Administrator wird sich dann gegebenenfalls bei Ihnen melden, wenn es Unstimmigkeiten gibt. In der Regel sollte das Hochstufen aber problemlos von Statten gehen, wenn Ihre bisherige Mitarbeit korrekt war.
    </p>
    <p>
        Sobald Sie als vertrauenswürdig eingestuft wurden, können Sie Kampagnen anlegen, Bilder zu Kampagnen zuordnen und vor allem müssen Ihre Beiträge nicht mehr alle moderiert/freigeschaltet werden. Sondern Sie dürfen die Sachen gleich veröffentlichen - was leicher und schneller für Sie und für uns ist.
    </p>
    <p>
        <b>Sollten Sie das Vertrauen nicht erfüllen, ist die Sonderrolle auch sehr schnell wieder weg und es kann dann sogar Ihr gesamter Account gelöscht werden!</b>
    </p>
    <h4><a name="user-level-moderator">Moderator</a></h4>
    <p>
        Wenn Sie sehr lange dabei sind oder sich anderweitig besonders ausgezeichnet haben, dann können Sie sogar den Status eines Moderators beantragen (gleicher Weg wie oben).
    </p>
    <p>
        Als Moderator können und sollen Sie dann die Bilder und Beiträge von normalen Nutzern moderieren.
    </p>
    <h4><a name="user-level-admin">Administrator</a></h4>
    <p>
        Der Status eines Administrators wird derzeit nicht außerhalb des Kernbetreiberteams vergeben.
    </p>
    <p>
        Ein Administrator kann Nutzer auf eine höhere Berechtigungsstufe setzen und er kann Bilder, Beiträge und sogar Nutzer komplett löschen.
    </p>
    <p style="height: 500px">
        
    </p>
</div>
