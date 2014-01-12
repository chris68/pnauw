<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\models\Campaign $model
 */

$this->title = 'Kampagne bearbeiten: ' . Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Kampagnen', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Html::encode($model->name), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="campaign-update">

	<h1><?= $this->title ?></h1>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
