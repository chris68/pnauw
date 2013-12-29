<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\models\Citation $model
 */

$this->title = 'Update Citation: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Citations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="citation-update">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
