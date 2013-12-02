<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\models\Picture $model
 */

$this->title = 'Create Picture';
$this->params['breadcrumbs'][] = ['label' => 'Pictures', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="picture-create">

	<h1><?= $this->title ?></h1>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
