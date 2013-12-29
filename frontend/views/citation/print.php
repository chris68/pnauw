<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Citation */

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\DetailView;


$this->title = 'Privatanzeige';
?>
<div class="citation-print">

	<?php
		/* var $pic frontend\models\Picture */
		foreach ($model->pictures as $pic) {
			echo $this->render('_printpicture', [
				'model' => $pic,
			]);
		}
	?>
	<!-- The header intentionally comes at the end to support better two side printing! -->
	<h1><?= Html::encode($this->title) ?></h1>
	<p>
		Dies ist eine Privatanzeige, die über die Plattform <b>Parke-nicht-auf-unseren-Wegen.de</b> erstellt wurde. Mit dieser Plattform 
		können betroffene Bürger Gehwegparker dokumentieren, die Autofahrer auf ihr mißbräuchliches Parken hinweisen und, wenn es nicht hilft
		oder das Parkverhalten nicht tolerierbar ist, auch anzeigen. Was hiermit gerade geschieht.
	</p>
	<!-- The field is currently not HTML encoded since markdown does not work yet -->
	<!-- However, since only the user himself will face the results we could not care less -->
	<h2>Spezifische Angaben für die Anzeige</h2>
	<p><?=$model->description?></p>
	<h2>Generelle Erläuterungen</h2>
	<p>
		Unter Vorfall ist genau dokumentiert, wie der Anzeiger die Lage entschätzt. Wenn es dort heißt <b>Gehwegparken (mit Behinderung)</b>, 
		dann ist in der Regel das erhöhte Verwarnungsgeld angemessen. Wenn dort die längere Standzeit über <b>(> 1h)</b> dokumentiert ist, dann ist 
		auch das erhöhte Verwarnungsgeld angemessen. In der Regel ist die längere Standzeit dann ja auch durch ein weiteres Photo dokumentiert.
	</p>
	<p>
		Wenn ein Auto an mehreren Tagen aufgeführt ist, dann ist dies in der Regel (wenn dem nicht indiviudell und ausdrücklich wiedersprochen wird) auch als <b>Mehrfachanzeige</b> gemeint. 
	</p>
	<p>
		Wenn die Anzeigen im Rahmen des Ermessenspielraums im Rahmen des Opportunitätsprinzips nicht in Verwarnungen umgesetzt wurden, dann bittet der Anzeiger 
		um eine kurze Info. Dies gilt weniger bei Nichtumsetzen von vereinzelten Anzeigen/Vorfällen - hier muss ja auch der Datenschutz des Betroffenen 
		beachtet werden. Sondern es geht vielmehr darum, dass ein Nichtumsetzen aller oder sehr vieler Anzeigen rechtlich eher nicht durch das Opportunitätsprinzip 
		abgedeckt wäre. Und dann will der Anzeiger eventuell die Möglichkeit des Rechtsweges oder der Dienstaufsichtsbeschwerde einschlagen.
		Und daher muss sichergestellt sein, dass die Anzeigen nicht einfach und in großen Stil einfach eingestellt werden.
		Denn der Anzeiger macht die Sache ja meist nicht aus Spass, sondern eher aus Notwehr, weil es die offiziellen Stellen nicht machen!
	</p>
</div>
