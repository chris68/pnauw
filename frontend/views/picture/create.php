<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */

use yii\helpers\Html;

$this->title = 'Anlage ohne Bild'.(Yii::$app->user->checkAccess('anonymous')?' (Gastzugang)':'');
$this->params['breadcrumbs'][] = ['label' => 'Bild', 'url' => ['manage']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['help'] = 'picture-create';
?>
<div class="picture-create">

	<?php echo $this->render('_formtabbed', [
		'model' => $model,
	]); ?>

</div>
