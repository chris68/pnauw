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
$this->params['breadcrumbs'][] = 'Kampagne';
$this->params['breadcrumbs'][] = Html::encode($model->name);
$this->params['help'] = 'campaign-show';
?>
<div class="campaign-view">

    
    <h1><?= $this->title ?></h1>
    <?= Html::a('Alle Bilder zur Kampagne anschauen', PictureController::urlCampaign('index', $model->id)) ?> 
    <?= (!yii::$app->user->isGuest?(' | '.Html::a('Meine Bilder zur Kampagne bearbeiten', PictureController::urlCampaign('manage', $model->id), ['target' => '_blank'])):'') ?>
    <?= ((yii::$app->user->can('isObjectOwner', array('model' => $model)))?(' | '.Html::a('Kampagne bearbeiten', ['campaign/update','id'=>$model->id], ['target' => '_blank'])):'') ?>
    <!-- @Todo: Add the mother and child campaigns in a box above and below the text -->
    <?= Markdown::convert(Html::encode($model->description))?>
    
</div>
