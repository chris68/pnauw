<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = 'Datenschutz';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-privacy">
    <h1><?= $this->title ?></h1>
    <h3>Datenschutzregeln</h3>

    <h4>Datennutzung</h4>
    <p>
        Alle Daten, die Sie als Nutzer hier einstellen, werden von uns nicht über diesen Service hinaus weitergegeben oder anderweitig genutzt. Wir werden die Daten nur dann herausgeben, wenn das Gesetz dies verlangt.
    </p>
    
    <h4>Anonymität</h4>
    <p>
        Wir werden die Nutzernamen oder Emailadressen der Nutzer, die Daten eingestellt haben, nie mit den eingestellten Daten der Nutzer öffentlich zusammen bringen. Nur wenn der Nutzer selbst die Daten anderen Nutzern explizit freigibt, dann wird seine Identität mit seinen Daten für andere erkennbar gebunden.
    </p>
    
    <h4>Datensicherheit</h4>
    <p>
        Wir sind bestrebt, Ihre Daten sehr gut zu schützen, können aber leider nicht garantieren, dass uns das in jedem Fall gelingen wird. Sobald wir jedoch ein Sicherheitsproblem in Erfahrung bringen, werden wir im Zweifel den Service bis zum Schließen der Sicherheitslücke vom Netz nehmen.
    </p>
    
    <h4>Verletzung von Datenschutzrechten</h4>
    <p>
        Wenn Sie als Nutzer oder Betroffener glauben, dass ihre Datenschutzrechte in irgendeiner Form verletzt wurden, dann infomieren Sie uns doch bitte über die Kontaktseite.
    </p>
    
    <h4>Nutzung von Cookies</h4>
    <p>
        Über die in der EU-Richtlinie erlaubten Nutzung von eigenen Cookies hinaus nutzen wir die Cookies von <a href="https://www.google.com/policies/privacy/partners/">Google Analytics</a> und von <a href="https://help.disqus.com/customer/portal/articles/466235-use-of-cookies">discus.com</a>.
        Daher müssen Sie deren Nutzung zustimmen. Ohne Zustimmung können Sie unsere Seite leider nicht nutzen.
    </p>

    <h4>Verarbeitung personenbezogener Daten (Datenschutzrichtlinie EU)</h4>
    <p>
        Über Google Analytics verarbeiten wir nur Zugriffs, wenn Sie NICHT angemeldet sind, und hierbei wird die IP-Adresse anonymisiert. Die Daten werden nur genutzt, um die Anzahl und 
        ungefähre geographische Verteilung der Nutzer zu sehen. Es gibt keinerlei personenbezogenen Analysen.
    </p>
    <p>
        Wir speichern als administrativen Serverlog den Zeitpunkt von einer Anmeldung bei unseren System, um missbräuchliche Attaken zu entdecken. Aus den gleichen Grund speichern wir die 
        HTTP-Request-Headerdaten (access.log), um missbräuchliche Zugriffe auf unser System zu entdecken. Die Daten werden unter keinen Umständen - außer wenn es das Gesetz verlangt - herausgegeben
        oder mit anderen Daten in Verbindung gebracht.
    </p>
    <p>
        Für diese Kennzeichenerkennungsfunktion wird ein Service der Internetseite <a href="<?= Url::to(['https://www.openalpr.com']) ?>">OpenALPR</a> genutzt. 
        Wenn Sie mit den auf dieser Seite veröffentlichen <a href="<?= Url::to(['https://cloud.openalpr.com/account/privacy']) ?>">Datenschutzbedingungen</a> nicht einverstanden sind, dann dürfen Sie die automatische Erkennung der Kennzeichen nicht nutzen.
    </p>
 
    <h4>Änderung der Datenschutzregeln</h4>
    <p>
        Alle Änderungen dieser Datenschutzregeln werden hier veröffentlicht und mit dem in bei Veröffentlichung angegebenen Gültigkeitdatum gültig. Wenn Sie mit den Änderungen nicht einverstanden sind, dann dürfen Sie den Service nicht weiter nutzen.
    </p>

    <p>
        (Stand 27.01.2019; gültig ab 27.01.2019)
    </p>
</div>
