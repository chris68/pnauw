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
		Die Hilfe wird gerade erstellt. Derzeit sind leider nur Fragmente enthalten.
	</div>

	<h2><a name="User-Level">Berechtigungsstufen</a></h2>
	<h3>Anonymer Nutzer / Gastzugang</h3>
	<p>
		Wenn Sie ohne eine Anmeldung arbeiten, dann sind Sie ein anonymer Nutzer und arbeiten im Gastzugang. Sie können dann Bilder hochladen und auch die Veröffentlichung beantragen. Aber Sie kommen später nie wieder an die Bilder dran. Daher sollten Sie sich bei einer regelmäßigen Nutzung registrieren.
	</p>
	<h3>Normaler Nutzer</h3>
	<p>
		Nachdem Sie sich registiert haben, sind Sie erst einmal ein normaler Nutzer, der noch eingeschränkte Rechte hat. Sie können keine Kampagnen anlegen und alle ihre hochgeladenen Bilder bzw. anderen Beiträge müssen moderiert/freigegeben werden.
	</p>
	<h3>Vertrauenswürdiger Nutzer</h3>
	<p>
		Wenn Sie einige Bilder hochgeladen haben und schon eine gewisse Zeit tätig sind, dann können Sie beantragen, als <em>vertrauenswürdiger Nutzer</em> eingestuft zu werden.
	</p>
	<p>
		Beantragen Sie dies bitte über die <a href="<?=Html::url(['contact'])?>">Kontaktmöglichkeit</a> unter Angabe Ihrer Anmeldadresse. Ein Administrator wird sich dann gegebenenfalls bei Ihnen melden, wenn es Unstimmigkeiten gibt. In der Regel sollte das Hochstufen aber problemlos von Statten gehen, wenn Ihre bisherige Mitarbeit korrekt war.
	</p>
	<p>
		Sobald Sie als vertrauenswürdig eingestuft wurden, können Sie Kampagnen anlegen, Bilder zu Kampagnen zuordnen und vor allem müssen Ihre Beiträge nicht mehr alle moderiert/freigeschaltet werden. Sondern Sie dürfen die Sachen gleich veröffentlichen - was leicher und schneller für Sie und für uns ist.
	</p>
	<p>
		<b>Sollten Sie das Vertrauen nicht erfüllen, ist die Sonderrolle auch sehr schnell wieder weg und es kann dann sogar Ihr gesamter Account gelöscht werden!</b>
	</p>
	<h3>Moderator</h3>
	<p>
		Wenn Sie sehr lange dabei sind oder sich anderweitig besonders ausgezeichnet haben, dann können Sie sogar den Status eines Moderators beantragen (gleicher Weg wie oben).
	</p>
	<p>
		Als Moderator können und sollen Sie dann die Bilder und Beiträge von normalen Nutzern moderieren.
	</p>
	<h3>Administrator</h3>
	<p>
		Der Status eines Administrators wird derzeit nicht außerhalb des Kernbetreiberteams vergeben.
	</p>
	<p>
		Ein Administrator kann Nutzer auf eine höhere Berechtigungsstufe setzen und er kann Bilder, Beiträge und sogar Nutzer komplett löschen.
	</p>
	
</div>
