<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\Citation */


$this->title = 'Anzeige bearbeiten: ' . Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Anzeigen', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Bearbeiten';
$this->params['help'] = 'citation-crud';
?>
<div class="citation-update">

    <h1><?= $this->title ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
