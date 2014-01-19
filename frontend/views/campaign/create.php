<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\models\Campaign $model
 */

$this->title = 'Kampagne anlegen';
$this->params['breadcrumbs'][] = ['label' => 'Kampagnen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['help'] = 'campaign-crud';
?>
<div class="campaign-create">

	<h1><?= $this->title ?></h1>

	<?php echo $this->render('_form', [
		'model' => $model,
	]); ?>

</div>
