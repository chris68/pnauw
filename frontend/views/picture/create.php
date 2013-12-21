<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */

use yii\helpers\Html;


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
