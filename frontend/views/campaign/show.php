<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\markdown\Markdown;

/**
 * @var yii\web\View $this
 * @var frontend\models\Campaign $model
 */

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = 'Kampagne';
$this->params['breadcrumbs'][] = Html::encode($model->name);
$this->params['help'] = 'campaign-show';
?>
<div class="campaign-view">

	<h1><?= $this->title ?></h1>
	<!-- @Todo: Add the mother and child campaigns in a box above and below the text -->
	<?= Markdown::convert(Html::encode($model->description))?>

</div>
