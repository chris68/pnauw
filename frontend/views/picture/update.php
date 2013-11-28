<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\models\Picture $model
 */

$this->title = 'Bearbeiten von Bild: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Bild', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Bearbeiten';
?>
<div class="picture-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
