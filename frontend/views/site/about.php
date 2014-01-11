<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = \Yii::t('base','About');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
	<h1><?= $this->title ?></h1>

	<h4>
		Problem: Mißbräuchliches Parken auf Gehwegen, Radwegen oder in verkehrsberuhigten Zonen
	</h4>
	<p>
		Das Problem des Gehwegparkens ist nach wie vor akut und leider wird es von offiziellen Stellen eher nicht ausreichend verfolgt
	</p>
	<p> 
		Obwohl es gemäß <a href="http://dejure.org/gesetze/StVO/12.html">StVO §12</a> in der Regel verboten ist. 
		Was aber viele Leute gar nicht wissen, sondern wie selbstverständlich lieber auf dem Gehweg parken als korrekt auf der Straße.
	</p>
	<p>
		Doch auf dieser Seite soll gar nicht versucht werden, dies genauer zu beleuchten, sondern nur auf andere relevante Seiten zu dem Thema verwiesen werden
	</p>
	<ul>
		<li><?= Html::a('Offizielle Seite "gehwege-frei.de" des Fuß eV','//www.gehwege-frei.de',['target' => '_blank']) ?></li>
		<li><?= Html::a('Initiative "Geh weg vom Gehweg" in Karlsruhe','//geh-weg-vom-gehweg.blogspot.de',['target' => '_blank']) ?></li>
		<li><?= Html::a('Verkehrswende Darmstadt', '//verkehrswende-darmstadt.wikispaces.com/Gehwegparken',['target' => '_blank']) ?></li>
	</ul>
	<p>
		Dort kann sich jeder informieren, wie die rechtliche Lage aussieht ("<b>Verboten</b>, wenn nicht ausdrücklich durch Schild erlaubt!"), 
		wann Gehwegparken eventuell toleriert werden kann ("Bei <b>echter</b> Parknot und dann mit <b>mindestens</b> 1,20 m Restbreite auf dem Gehweg") und 
		wie teuer Verstöße sind ("Verwarnungsgeld von <b>20,- EUR bis 35,- EUR</b>").
	</p>
	<h4>
		Hilfe zur Selbsthilfe
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
		Die Plattform "Parke nicht auf unseren Wegen"
	</h4>
	<p>
		Die Plattform ist eine Webapplikation, die voll auf HTML5 und den damit verbundenen Möglichkeiten setzt. Die Webseiten sind hierbei 
		speziell für den Einsatz auf mobilen Geräten optimiert. Ältere Browser (vor allem nicht ältere Internet Exlorer!) werden als Konsequenz 
		nicht unterstützt und es wird ausdrücklich empfohlen, einen aktuellen und HTML5-kompatiblen Browser einzusetzen.
	</p>
	<p>
		Sollte es Probleme mit <b>aktuellen</b> Browsern geben, dann melden Sie diese bitte über die Kontaktseite.
	</p>
	<?php if (!Yii::$app->user->isGuest) : ?>
	<p>
		<div class="col-sm-12 col-md-12 alert alert-warning">
			Das System ist derzeit noch in Entwicklung und es wird daher noch gewisse Nutzungseinschränkungen geben!
		</div>
	</p>
	<?php endif ?>
</div>
