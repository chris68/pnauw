<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\markdown\Markdown;
use frontend\controllers\PictureController;

/**
 * @var yii\web\View $this
 * @var frontend\models\Campaign $model
 */

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Kampagnen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['help'] = 'campaign-crud';
?>
<div class="campaign-view">

    <h1><?= $this->title ?></h1>

    <p>
        <?= Html::a('Bearbeiten', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('Löschen', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data-confirm' => 'Sind Sie sich mit dem Löschen sicher?',
            'data-method' => 'post',
        ]); ?>
        <?= Html::a('Kopieren', ['copy', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
    </p>
    
    <?= Html::a('Öffentliche Kampagnendarstellung zeigen',['campaign/show','id' => $model->id], ['target' => '_blank'] ) ?>
    

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name:ntext',
            [
                'label' => 'Beschreibung',
                'format' => 'raw',
                'value' => Markdown::convert(Html::encode($model->description)),
            ],
            'running_from',
            'running_until',
            [
                'label' => 'Sichtbarkeit',
                'value' => $model->visibility->name,
            ],
            /*'loc_path',*/
            'created_ts',
            'modified_ts',
            'released_ts',
            'deleted_ts',
        ],
    ]); ?>

</div>
