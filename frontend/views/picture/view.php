<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use frontend\helpers\Assist;
use frontend\views\picture\assets\PictureLocationmapAsset;

PictureLocationmapAsset::register($this);

$this->title = 'Vorfall ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bilder', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Anzeigen/Beschwerden';
$this->params['help'] = 'picture-view';
?>
<div class="picture-view">
    <div class="row">
        <?php if ($model->isLegacy()): ?>
        <div class="col-sm-4 col-md-4 col-lg-4">
            <p>(Der Vorfall wurde vor über einem Jahr dokumentiert und daher werden hierzu keine Details mehr veröffentlicht).</p>
        </div>
        <?php else: ?>
        <div class="col-sm-4 col-md-4 col-lg-4">
            <p><b><?=Html::encode($model->name)?></b></p>
            <p><?=nl2br(Html::encode($model->description))?></p>
            <?= frontend\widgets\ImageRenderer::widget(
                [
                    'image' => $model->blurredMediumImage,
                    'size' => 'medium',
                    'options' => ['class' => 'img-responsive', 'style' => 'margin-bottom:10px'],
                ])
            ?>
        </div>
        <div class="col-sm-4 col-md-4 col-lg-4">
            <p><?=(($model->incident_id != -1)?('<b>'.Html::encode($model->incident->name).'</b>'):'<i>Der Vorfall wurde leider nicht klassifiziert</i>')?></p>
            <p>Vorfall am <b><?=date_format(date_create($model->taken),'d.m.Y')?></b></p>
            <p><?=(($model->action_id != -1)?('<b>Maßnahme:</b> '.Html::encode($model->action->name)):'')?></p>
            <p><?=((isset($model->campaign_id))?('<b>Kampagne:</b> '.Html::a(Html::encode($model->campaign->name),['campaign/show','id' => $model->campaign_id], ['target' => '_blank'] )):'')?></p>
            <?php
                echo Html::tag('div','', [
                  'style' => 'height: 300px;',
                  'id' => 'map',
                  'data' => [
                      'map' => 1,
                      'lat' => $model->loc_lat,
                      'lng' => $model->loc_lng,
                      'zoom' => 16,
                  ]
                ]);
            ?>
            <p>
                <a href="https://www.google.de/maps/@<?=$model->loc_lat?>,<?=$model->loc_lng?>,80m/data=!3m1!1e3" target="_blank">Satellitenkarte</a>
                <?=((yii::$app->user->can('isObjectOwner', array('model' => $model)))?('&nbsp;'.Html::a('<span class="glyphicon glyphicon-pencil btn-sm"></span>', ['picture/update','id'=>$model->id])):'')?>
            </p>
            <p><?=(!empty($model->loc_formatted_addr)?Html::encode($model->loc_formatted_addr):'<i>Der Ort wurde leider noch nicht ermittelt</i>')?></p>
        </div>
        <a name="disqus_thread"></a><div class="col-sm-4 col-md-4 col-lg-4">
            <div id="disqus_thread"></div>
            <script type="text/javascript">
                /* * * CONFIGURATION VARIABLES * * */
                var disqus_shortname = 'pnauw';
                var disqus_identifier = '/picture/<?= $model->id ?>';
                var disqus_url = '<?= Url::to(['picture/view','id'=> $model->id],true)?>';
                /* * * DON'T EDIT BELOW THIS LINE * * */
                (function() {
                    var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
                    dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
                    (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
                })();
            </script>
            <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
        </div>
        <?php endif; ?>
    </div>
</div>
