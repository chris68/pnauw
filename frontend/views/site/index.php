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

				<p><a class="btn btn-default" href="<?= Url::to(['/picture/index', 's[time_range]' => '-30;0', 's[map_bind]' => '1'])?>">Die aktuellen Vorfälle&raquo;</a></p>
			</div>
			<div class="col-md-4">
				<h2>Fußgänger</h2>

				<p>Sie sind Fußgänger und finden es nicht lustig, wie ihre Gehwege zugeparkt sind?</p> 
				<p>Dann melden Sie die Vorfälle doch einfach. Geht ganz schnell mit der Handykamera und Sie müssen sich dafür nicht einmal registrieren!</p>

				<p><a class="btn btn-default" href="<?= Url::to(['/picture/guestcapture'])?>">Vorfall als Gast melden&raquo;</a></p>
			</div>
			<div class="col-md-4">
				<h2>Mitarbeit</h2>

				<p>Sie wollen richtig mitarbeiten und regelmäßig oder im größeren Stil Gehwegparker dokumentieren?</p>
				<p>Dann <?= Html::a("registrieren",['/site/signup'])?> Sie sich und laden ihre ganzen Bilder von Gehwegparkern hoch!</p>

				<p><a class="btn btn-default" href="<?= Url::to(['picture/upload'])?>">Bilder hochladen&raquo;</a></p>
				<p>Und wenn Sie länger dabei sind, dann beantragen Sie am besten schleunigst eine höhere <a href="<?=Url::to(['help']).'#user-level'?>">Berechtigungsstufe</a></p>
			</div>
		</div>

	</div>
</div>
