<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\markdown\Markdown;
use yii\helpers\HtmlPurifier;
use frontend\controllers\PictureController;

/* @var $this yii\web\View */
/* @var $model frontend\models\Flyer */

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Zettel', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['help'] = 'flyer-crud';
?>
<div class="flyer-view">

    <h1><?= $this->title ?></h1>

    <p>
        <?= Html::a('Bearbeiten', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?php echo Html::a('Löschen', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data-confirm' => 'Sind Sie sich mit dem Löschen sicher?',
            'data-method' => 'post',
        ]); ?>
        <?= Html::a('Kopieren', ['copy', 'secret' => $model->secret], ['class' => 'btn btn-default']) ?>
    </p>
    
    <?= Html::a('Öffentliche Zetteldarstellung zeigen',['flyer/show','secret' => $model->secret], ['target' => '_blank'] ) ?>
    |
    <?= Html::a('Zettel drucken',['flyer/print','secret' => $model->secret], ['target' => '_blank'] ) ?>
    

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name:ntext',
            [
                'label' => 'Beschreibung',
                'format' => 'raw',
                'value' => HtmlPurifier::process(Markdown::convert($model->description)),
            ],
            [
                'label' => 'Zetteltext',
                'format' => 'raw',
                'value' => HtmlPurifier::process(Markdown::convert($model->flyertext)),
            ],
            'secret',
            'running_from',
            'running_until',
            'loc_filter',
            'created_ts',
            'modified_ts',
            'released_ts',
            'deleted_ts',
        ],
    ]); ?>

</div>
