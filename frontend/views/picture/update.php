<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */

use yii\helpers\Html;

$this->title = 'Bearbeiten von Bild: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bild', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Bearbeiten';
?>
<div class="picture-update">

	<?php echo $this->render('_formtabbed', [
		'model' => $model,
	]); ?>

</div>
