<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Flyer */

use yii\helpers\Html;
use frontend\controllers\PictureController;


$this->title = 'Zettel bearbeiten: ' . Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Zettel', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => Html::encode($model->name), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$this->params['help'] = 'flyer-crud';
?>
<div class="flyer-update">

    <?= Html::a('Öffentliche Darstellung zeigen',['flyer/show','secret' => $model->secret], ['target' => '_blank'] ) ?>
    |
    <?= Html::a('Zettel drucken',['flyer/print','secret' => $model->secret], ['target' => '_blank'] ) ?>
    
    <h1><?= $this->title ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
