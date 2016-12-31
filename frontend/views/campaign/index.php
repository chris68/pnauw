<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\bootstrap\Collapse;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\CampaignSearch */
 
$this->title = 'Kampagnen';
$this->params['breadcrumbs'][] = ['label' => 'Kampagnen', 'url' => ['index']];
$this->params['help'] = 'campaign-crud';
?>
<div class="campaign-index">

    <h1><?= $this->title ?></h1>

    <?=
        Collapse::widget([
            'items' => [
                [
                    'label' => '<span class="glyphicon glyphicon-collapse-down"></span> Suchen und Filtern <span class="badge">'.$searchModel->getFilterStatus().'</span>' ,
                    'encode' => false,
                    'content' => $this->render('_search', ['model' => $searchModel]),
                ],
            ],
            'options' => 
            [
                'style' => 'margin-bottom: 10px'
            ],
       ]);
    ?>

    <p>
        <?= Html::a('Kampagne anlegen', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model->name), ['view', 'id' => $model->id]);
        },
    ]); ?>

</div>
