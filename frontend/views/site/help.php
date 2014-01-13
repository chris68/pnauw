<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Hilfe';
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
	/* 
		Otherwise when navigating to an anchor the heading is hidden behind the navbar 
		See http://stackoverflow.com/questions/9047703/fixed-position-navbar-obscures-anchors
	*/
	.site-about a[name] {
		padding-top: 60px;
		margin-top: -60px;
	}	
</style>
<div class="site-about">
	<h1><?= $this->title ?></h1>

	<div class="alert alert-warning">
		Die Hilfe wird gerade erstellt und ist daher noch nicht vollständig.
	</div>

	<h2><a name="picture">Bilder</a></h2>
	<h3><a name="picture-general">Generell</a></h3>
	<p>
		Als Bilder sind ausschließlich JPEG-Dateien erlaubt. Die Bilder werden nach dem Hochladen folgendermaßen verarbeitet
	</p>
	<ol>
		<li>Das Bild wird gemäß der EXIF-Ausrichtung gedreht</li>
		<li>Das Originalbild wird dann ohne weitere Änderungen abgespeichert. <b>Es ist so aber nur für den Eigner sichtbar!</b></li>
		<li>Es werden dann Verkleinerungen in der Größe Thumbnail, Small und Medium generiert. <b>Auch diese sind nur für den Eigner sichtbar!</b></li>
		<li>Die Verkleinerungen werden dann in einer zweiten Version verschwommen abgespeichert. <b>Nur diese Versionen sind für die Öffentlichkeit bestimmt!</b></li>
		<li>Bei allen Verkleinerungen werden alle EXIF-Parameter gelöscht - es ist also keine Kamerakennung etc. mehr erkennbar</li>
		<li>Vorher wird noch das Aufnahmedatum und eventuell vorhandene GEO-Koordinaten aus den Bilder ausgelesen und gespeichert.</li>
	</ol>
	<p>
		Bei den Bildern gibt es eine Größenbegrenzung (siehe Hinweis beim Hochladen). Zudem ist es für die Layouts der Masken empfehlenswert, wenn die Bilder <b>Hochkant</b> aufgenommen werden.
	</p>
	<h3><a name="picture-capture">Bilder aufnehmen</a></h3>
	<p>
		Bei den meisten Kameras in Smartphone können Sie direkt aus dem Browser heraus ein Bild aufnehmen, dass dann gleich hochgeladen wird.
		Wegen der Größenbeschränkung sollte Sie die Kamera nur vorher schnell auf z.B. nur 0.3 MB große Bilder einstellen, damit Sie nicht mit der Maximalgröße Probleme bekommen.
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
		Das Hochladen von einem oder mehreren Bilder aus einem Ordner ist ebenso möglich. Wenn die Bilder im Original zu groß sind, dann müssen Sie diese voher 
		entsprechend verkleinern, denn durch das Hochladen unnötig großer Bilder wäre die Last für unseren Server zu hoch.
	</p>
	<p>
		Wenn Sie sehr, sehr viele Bilder hochladen, dann sollten Sie die Bilder am besten von 1 ab durchnumerieren bzw. irgendwie sortieren, damit Sie nicht durcheinander kommen. 
		Es werden daher auch immer das erste und das letzte hochgeladene Bild nach dem Hochladen nochmal angezeigt, damit Sie wissen, wo Sie gerade stehen.
	</p>
	<h3><a name="picture-guestupload">Bilder hochladen (Gastzugang) </a></h3>
	<p>
		Auch das Hochladen von Bildern ist als <a href="#user-level-anonymous">anonymer Nutzer</a> möglich. Aber auch hier bitte daran denken, die Beantragung der Veröffentlichung der Bilder nicht zu vergessen!
	</p>
	<h3><a name="picture-create">Vorfall ohne Bild anlegen</a></h3>
	<p>
		Manchmal gibt es Situationen, wo Sie gerade keine Kamera haben bzw. kein gutes Bild machen können (z.B. Nachts). Dann können Sie trotzdem einen Vorfall ohne Bild anlegen. Der Vorfall wird dann jedoch automatisch und nicht änderbar auf den Zeitpunkt der Anlage datiert.
	</p>
	<h3><a name="picture-manage">Bilder bearbeiten</a></h3>
	<p>
		Nach dem Hochladen müssen Sie die Bilder bearbeiten. Es gibt hierzu eine Mehrfachbearbeitung, wo Sie immer mehrere Bilder gleichzeitig bearbeiten können und eine Einzelbearbeitung, wo Sie jeweils nur ein einzelnes Bild bearbeiten.
	</p>
	<p>
		Die Mehrfachbearbeitung ist vor allem für große Kampagnen gedacht, wo Sie sehr, sehr viele Bilder schnell klassifzieren wollen, aber keine großen Detailinfos (wie z.B. Autonummern) eingeben wollen und die Masken sind für diesen Zweck sehr effizient aufgebaut.
		So ist zum Beispiel die Tabulatorreihenfolge so optimiert, dass Sie über das Feld <em>Vorfall</em> sehr schnell durchspringen können. Auch die Auswahllisten sind so intelligent 
		aufgebaut, dass Sie mit Buchstaben wie 'G' schnell und leicht den korrekten Verfall wählen können.
	</p>
		Einen Nachteil hat die Mehrfachbearbeitung - <b>eventuelle Eingabefehler werden nicht angezeigt, sondern der Satz wird einfach nicht gespeichert!</b>
		In der Regel kein Problem, weil man über die Felder so gut wie nie Eingabefehler erzeugen kann. 
	</p>
	<p>
		Einzige Ausnahme ist die Sichtbarkeit: Sie können halt nur veröffentlichen, wenn Sie es auch dürfen (siehe <a href="#picture-publish">Bilder veröffentlichen</a>). Daher hier lieber die Veröffentlichungsmaske nutzen!
	<p>
	</p>
	<h3><a name="picture-update">Bilder detailliert bearbeiten</a></h3>
	<p>
		Bei der Einzelbearbeitung ist die Maske hingegen auf mehrere Reiter aufgeteilt, wo in jedem Reiter ein Themengebiet abgedeckt ist.
	</p>
	<h4><a name="picture-update-imagetab">Reiter "Bild &amp; Kfz-/Vorfallsdaten"</a></h4>
	<p>
		In dem Reiter können Sie durch Klicken auf das Bild und den Ziehen des Zoom-Reglers sich das Kennzeichen genau rauszoomen. Das hilft beim Erfassen und das Detailbild kommt dann auch automatisch auf die Anzeige.
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
	<h3><a name="picture-update">Mehrere Bilder detailliert bearbeiten</a></h3>
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
		Ansonsten müssen Sie die Veröffentlichung beantragen und in der Regel wird ein <a href="#user-level-trusted">Moderator</a> dies auch zeitnah freigeben.
		Sollte der Moderator nicht einverstanden sein, wird er die Veröffentlichung ablehnen.
		Übrigens sieht selbst der Moderator nur die verschwommenen Bilder - die unverschwommenen sehen immer nur Sie selbst!
	</p>

	<h2><a name="user-level">Berechtigungsstufen</a></h2>
	<h3><a name="user-level-anonymous">Anonymer Nutzer / Gastzugang</a></h3>
	<p>
		Wenn Sie ohne eine Anmeldung arbeiten, dann sind Sie ein anonymer Nutzer und arbeiten im Gastzugang. Sie können dann Bilder hochladen und auch die Veröffentlichung beantragen. Aber Sie kommen später nie wieder an die Bilder dran. Daher sollten Sie sich bei einer regelmäßigen Nutzung registrieren.
	</p>
	<h3><a name="user-level-normal">Normaler Nutzer</a></h3>
	<p>
		Nachdem Sie sich registiert haben, sind Sie erst einmal ein normaler Nutzer, der noch eingeschränkte Rechte hat. Sie können keine Kampagnen anlegen und alle ihre hochgeladenen Bilder bzw. anderen Beiträge müssen moderiert/freigegeben werden.
	</p>
	<h3><a name="user-level-trusted">Vertrauenswürdiger Nutzer</a></h3>
	<p>
		Wenn Sie einige Bilder hochgeladen haben und schon eine gewisse Zeit tätig sind, dann können Sie beantragen, als <em>vertrauenswürdiger Nutzer</em> eingestuft zu werden.
	</p>
	<p>
		Beantragen Sie dies bitte über die <a href="<?= Html::url(['contact']) ?>">Kontaktmöglichkeit</a> unter Angabe Ihrer Anmeldadresse. Ein Administrator wird sich dann gegebenenfalls bei Ihnen melden, wenn es Unstimmigkeiten gibt. In der Regel sollte das Hochstufen aber problemlos von Statten gehen, wenn Ihre bisherige Mitarbeit korrekt war.
	</p>
	<p>
		Sobald Sie als vertrauenswürdig eingestuft wurden, können Sie Kampagnen anlegen, Bilder zu Kampagnen zuordnen und vor allem müssen Ihre Beiträge nicht mehr alle moderiert/freigeschaltet werden. Sondern Sie dürfen die Sachen gleich veröffentlichen - was leicher und schneller für Sie und für uns ist.
	</p>
	<p>
		<b>Sollten Sie das Vertrauen nicht erfüllen, ist die Sonderrolle auch sehr schnell wieder weg und es kann dann sogar Ihr gesamter Account gelöscht werden!</b>
	</p>
	<h3><a name="user-level-moderator">Moderator</a></h3>
	<p>
		Wenn Sie sehr lange dabei sind oder sich anderweitig besonders ausgezeichnet haben, dann können Sie sogar den Status eines Moderators beantragen (gleicher Weg wie oben).
	</p>
	<p>
		Als Moderator können und sollen Sie dann die Bilder und Beiträge von normalen Nutzern moderieren.
	</p>
	<h3><a name="user-level-admin">Administrator</a></h3>
	<p>
		Der Status eines Administrators wird derzeit nicht außerhalb des Kernbetreiberteams vergeben.
	</p>
	<p>
		Ein Administrator kann Nutzer auf eine höhere Berechtigungsstufe setzen und er kann Bilder, Beiträge und sogar Nutzer komplett löschen.
	</p>
</div>
