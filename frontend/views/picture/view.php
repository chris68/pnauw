<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = 'Anzeigen von Bild: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bilder', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="picture-view">

	<?php echo DetailView::widget([
		'model' => $model,
		'attributes' => [
			'id',
			'name:ntext',
			'description:ntext',
			'taken',
		],
	]); ?>

</div>
