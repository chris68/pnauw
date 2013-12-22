<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */

use yii\helpers\Html;

$this->title = 'Neuanlage' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bild', 'url' => ['manage', 'sort'=>'modified_ts-desc', ]];
$this->params['breadcrumbs'][] = 'Neuanlage';
?>
<div class="picture-create">

	<?php echo $this->render('_formtabbed', [
		'model' => $model,
	]); ?>

</div>
