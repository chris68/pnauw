<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Citation */


use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\markdown\Markdown;

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = ['label' => 'Anzeigen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['help'] = 'citation-crud';
?>
<div class="citation-view">

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

    <?php echo DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => $model->getAttributeLabel('type'),
                'format' => 'raw',
                'value' => $model->encodeType(),
            ],
            'name:ntext',
            [
                'label' => $model->getAttributeLabel('description'),
                'format' => 'raw',
                'value' => Markdown::convert(Html::encode($model->description)),
            ],
            'created_ts',
            'modified_ts',
            //'released_ts',
        ],
    ]); ?>
    
    <?=Html::a('Vorfälle der Anzeige bearbeiten',['picture/manage', 's[citation_id]' => $model->id,'sort' => 'vehicle_reg_plate'],['target' => '_blank']) ?>
     | <?=Html::a('Anzeige drucken (als Druckansicht darstellen)',['print', 'id' => $model->id, ],['target' => '_blank']) ?>

</div>
