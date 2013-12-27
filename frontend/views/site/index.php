<?php
/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = \Yii::$app->name;
?>
<div class="site-index">

	<div class="jumbotron">
		<h1>Parke nicht auf unseren Wegen!</h1>

		<p class="lead">Gehwegparken nervt und ist meist unnötig. Mit der Methode <a href="http://dictionary.cambridge.org/dictionary/british/name-and-shame">Name and Shame</a> werden wir es bekämpfen.</p>

	</div>

	<div class="body-content">

		<div class="row">
			<div class="col-md-4">
				<h2>Autofahrer</h2>

				<p>Sie sind ein Autofahrer und hatten einen Zettel am Auto? Dann schauen Sie doch einfach, was man zu Ihrem Parkverhalten sagt. </p>

				<p><a class="btn btn-default" href="<?= Html::url(['picture/index'])?>">Die aktuellen Vorfälle&raquo;</a></p>
			</div>
			<div class="col-md-4">
				<h2>Fußgänger</h2>

				<p>Sie sind Fußgänger und finden es auch nicht lustig, wie ihr Gehweg zugeparkt ist? Dann schauen Sie mal, was in Ihrer Gegend schon gemeldet ist und beteiligen sich eventuell auch!</p>

				<p><a class="btn btn-default" href="<?= Html::url(['picture/index'])?>">Die aktuellen Vorfälle&raquo;</a></p>
			</div>
			<div class="col-md-4">
				<h2>Mitarbeit</h2>

				<p>Sie wollen mitarbeiten und auch Gehwegparker dokumentieren? Dann registrieren Sie sich und laden ihre Bilder von Gehwegparkern hoch! </p>

				<p><a class="btn btn-default" href="<?= Html::url(['picture/upload'])?>">Bilder hochladen&raquo;</a></p>
			</div>
		</div>

	</div>
</div>
