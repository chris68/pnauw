<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel frontend\models\PictureSearch */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\bootstrap\Collapse;
use yii\widgets\Pjax;


$this->title = 'Bilder';
$this->params['breadcrumbs'][] = ['label' => 'Bilder', 'url' => ['index']];
$this->params['help'] = 'picture-index';
?>
<div class="picture-index">

    <?=
        Collapse::widget([
            'items' => [
                [
                    'label' =>  '<span class="glyphicon glyphicon-collapse-down"></span> Suchen und Filtern <span class="badge">'.$searchModel->getFilterStatus().'</span>',
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

    <?= $this->render('_quicksearchbar') ?>

    <?= $this->render('_overviewmap', ['private' => 0]) ?>

    <div style="margin-top: 10px;">
    <?php
        {
            // Generate the massview link by changing the route and throwing out sort/pagination

            $params = Yii::$app->getRequest()->getQueryParams();

            unset($params[$dataProvider->getPagination()->pageParam]);
            unset($params[$dataProvider->getSort()->sortParam]);
            $params[$dataProvider->getSort()->sortParam] = 'id';
            $params[0] = '/picture/massview';
            
            echo Html::a('Im Detail anschauen', Url::toRoute($params), ['target' => '_blank']);
            if (!Yii::$app->user->isGuest) {
                $params[0] = '/picture/massupdate';
                echo ' | '.Html::a('Im Detail bearbeiten', Url::toRoute($params), ['target' => '_blank']);
            }
        }
    ?>
    </div>
    
    <?php Pjax::begin(['id' => 'main', 'enablePushState' => TRUE, 'timeout' => 10000, 'linkSelector' => '.pagination a', 'formSelector' => '', ]); ?>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{pager}\n{summary}\n{items}\n{pager}",
        'id' => 'picture-list',
        'itemView' => function ($model, $key, $index, $widget) {
            if ($model->isLegacy()) {
                return
                '<div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4">'
                .
                    '<hr>'
                .
                    '<p>'
                .
                    (($model->incident_id != -1)?('<b>'.Html::encode($model->incident->name).'</b>'):'<i>Der Vorfall wurde leider nicht klassifiziert</i>')
                .
                    '</p><p>'
                .
                     'Vorfall aus dem Jahr <b>'.date_format(date_create($model->taken),'Y').'</b>'
                .
                    '</p><p>'
                .
                    '<i>(Der Vorfall wurde vor über einem Jahr dokumentiert und daher werden hierzu keine Details mehr veröffentlicht)</i>'
                .
                    '</p><p>'
                .
                    (!empty($model->loc_formatted_addr)?Html::encode($model->loc_formatted_addr):'<i>Der Ort wurde leider noch nicht ermittelt</i>')
                .
                    '</p>'
                .
                    '<p>'
                .
                    '</p><p>'
                .
                    ((isset($model->campaign_id))?('<b>Kampagne:</b> '.Html::a(Html::encode($model->campaign->name),['campaign/show','id' => $model->campaign_id], ['target' => '_blank'] )):'')
                .
                    '</p>'
                .
                    '<p></p>'
                .
                    '<hr>'
                .
                    '</div>'
                .
                '</div>'
                ;
            } else {
                return
                '<div class="row">
                    <div class="col-sm-4 col-md-4 col-lg-4">'
                .
                    '<hr>'
                .
                    '<p><b>'
                .
                    Html::encode($model->name)
                .
                    '</b></p>'
                .
                    nl2br(Html::encode($model->description))
                .
                    '</p>'
                .
                        frontend\widgets\ImageRenderer::widget(
                            [
                                'image' => $model->blurredSmallImage,
                                'size' => 'small',
                                'options' => ['class' => 'img-responsive', 'style' => 'min-width:80%; margin-bottom:10px'],
                            ]
                        )
                .
                    Html::a('Detail', ['picture/view','id'=>$model->id], ['target' => '_blank'])
                .
                    ((yii::$app->user->can('isObjectOwner', array('model' => $model)))?(' | '.Html::a('Bearbeiten', ['picture/update','id'=>$model->id], ['target' => '_blank'])):'')
                .
                    '<p>'
                .
                    (!empty($model->loc_formatted_addr)?Html::encode($model->loc_formatted_addr):'<i>Der Ort wurde leider noch nicht ermittelt</i>')
                .
                    '</p>'
                .
                    '<p>'
                .
                    (($model->incident_id != -1)?('<b>'.Html::encode($model->incident->name).'</b>'):'<i>Der Vorfall wurde leider nicht klassifiziert</i>')
                .
                    '</p><p>'
                .
                        'Vorfall am <b>'.date_format(date_create($model->taken),'d.m.Y').'</b>'
                .
                    '<p>'
                .
                    (($model->action_id != -1)?('<b>Maßnahme:</b> '.Html::encode($model->action->name)):'')
                .
                    '</p><p>'
                .
                    ((isset($model->campaign_id))?('<b>Kampagne:</b> '.Html::a(Html::encode($model->campaign->name),['campaign/show','id' => $model->campaign_id], ['target' => '_blank'] )):'')
                .
                    '</p><p>'
                .
                    '</p>'
                .
                    '<hr>'
                .
                    '</div>'
                .
                '</div>'
                ;
            }
        },
    ]); ?>
    <?php Pjax::end(); ?>
</div>