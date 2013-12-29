<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\models\Citation $model
 */

$this->title = 'Create Citation';
$this->params['breadcrumbs'][] = ['label' => 'Citations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="citation-create">

	<h1><?= Html::encode($this->title) ?></h1>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
