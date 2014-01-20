<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Campaign */

use yii\helpers\Html;
use frontend\controllers\PictureController;


$this->title = 'Kampagne bearbeiten: ' . Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Kampagnen', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Html::encode($model->name), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['help'] = 'campaign-crud';
?>
<div class="campaign-update">

	<?= Html::a('Alle Bilder zur Kampagne', PictureController::urlCampaign('index', $model->id)) ?> | 
	<?= Html::a('Öffentliche Kampagnendarstellung zeigen',['campaign/show','id' => $model->id], ['target' => '_blank'] ) ?>
	
	<h1><?= $this->title ?></h1>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
