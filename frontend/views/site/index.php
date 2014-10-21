<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use yii\helpers\Url;

$this->title = \Yii::$app->name;
?>
<div class="site-index">

	<div class="jumbotron">
		<h1>Parke nicht auf unseren Wegen!</h1>

		<p class="lead">Gehwegparken nervt und ist meist unnötig. Mit der Methode <a href="http://dictionary.cambridge.org/dictionary/british/name-and-shame">Name and Shame</a> werden wir es bekämpfen. </p>
		<p><small><a href="<?= Url::to(['site/about']) ?>">Hintergrundsinfos</a> &ndash; <a href="<?= Url::to(['site/help']) ?>">Hilfe</a></small></p>

	</div>

	<div class="body-content">

		<div class="row">
			<div class="col-md-4">
				<h2>Autofahrer</h2>

				<p>Sie sind ein Autofahrer und hatten einen Zettel am Auto?</p>
				<p>Dann schauen Sie doch einfach, was man zu Ihrem Parkverhalten sagt!</p>

				<p>
					<a class="btn btn-default" href="<?= Url::to(['/picture/index', 's[time_range]' => '-30;0', 's[map_bind]' => '1'])?>">Die aktuellen Vorfälle&raquo;</a>
				</p>
			</div>
			<div class="col-md-4">
				<h2>Fußgänger</h2>

				<p>Sie sind Fußgänger und finden es nicht lustig, wie ihre Gehwege zugeparkt sind?</p> 
				<p>Dann melden Sie die Vorfälle doch einfach!</p>

				<p>
					<a class="btn btn-default" href="<?= Url::to(['/picture/capture'])?>">Vorfall melden&raquo;</a>
					<a class="btn btn-default" href="<?= Url::to(['/picture/guestcapture'])?>">als Gast&raquo;</a>
				</p>

				<p>Geht ganz schnell mit der Handykamera und mit dem <a href="<?=Url::to(['help']).'#picture-guestcapture'?>" target="_blank">Gastzugang</a>  müssen sich nicht einmal registrieren.</p>
			</div>
			<div class="col-md-4">
				<h2>Mitarbeit</h2>

				<p>Sie wollen im größeren Stil Gehwegparker dokumentieren?</p>
				<p>Dann laden Sie einfach ihre ganzen Bilder hoch!</p>

				<p>
					<a class="btn btn-default" href="<?= Url::to(['picture/upload'])?>">Bilder hochladen&raquo;</a>
					<a class="btn btn-default" href="<?= Url::to(['picture/guestupload'])?>">als Gast&raquo;</a>
				</p>
				
				<p>Geht auch im <a href="<?=Url::to(['help']).'#picture-guestupload'?>" target="_blank">Gastzugang</a>, aber besser Sie <?= Html::a("registrieren",['/site/signup'])?> sich hierzu.
				Und bei reger Teilnahme sollten Sie baldigst eine höhere <a href="<?=Url::to(['help']).'#user-level'?>" target="_blank">Berechtigungsstufe</a> beantragen.</p>
			</div>
		</div>

	</div>
</div>
