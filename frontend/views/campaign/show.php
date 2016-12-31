<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\markdown\Markdown;
use frontend\controllers\PictureController;
use Imagick;
use ImagickDraw;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model frontend\models\Campaign */

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = 'Kampagne';
$this->params['breadcrumbs'][] = Html::encode($model->name);
$this->params['help'] = 'campaign-show';
?>
<div class="campaign-view">

    
    <h1><?= $this->title ?></h1>
    <a href="#disqus_thread">Diskussionen</a> |
    <?= Html::a('Kontakt aufnehmen', ['contact','id'=>$model->id], ['target' => '_blank']) ?> |
    <?= Html::a('Alle Bilder zur Kampagne anschauen', PictureController::urlCampaign('index', $model->id), ['target' => '_blank']) ?>
    <?= (!yii::$app->user->isGuest?(' | '.Html::a('Meine Bilder zur Kampagne bearbeiten', PictureController::urlCampaign('manage', $model->id), ['target' => '_blank'])):'') ?>
    <?= ((yii::$app->user->can('isObjectOwner', array('model' => $model)))?(' | '.Html::a('Kampagne bearbeiten', ['campaign/update','id'=>$model->id], ['target' => '_blank'])):'') ?>
    <?php
        $stack = new Imagick();
        /* var $pic frontend\models\Picture */
        foreach ($model->getPictures()->andWhere(['is not','blurred_thumbnail_image_id',NULL])->orderBy(['random()' => SORT_ASC, ])->limit(20)->all() as $pic) {
            $thumb = new Imagick();
            if (isset($pic->blurredThumbnailImage)) {
              $imageBlob = hex2bin(stream_get_contents($pic->blurredThumbnailImage->rawdata, -1, 0));
            }
            $thumb->readImageBlob($imageBlob);
            $stack->addImage($thumb);
        }
        $montage = $stack->montageImage(new ImagickDraw(), '5x4', '', 0, '0');
        $montage->setImageFormat('jpg');

        $options = array();
        $options['src'] = 'data:image/jpg;base64,' . base64_encode($montage->getImageBlob());
        $options['alt'] = 'Vorfälle der Kampagne';
    ?>
    <?php Pjax::begin(['id' => 'samplepics', 'enablePushState' => false, 'timeout' => 10000, ]); ?>

    <div style="margin-top: 10px">
    <?= \yii\helpers\Html::tag('img','',$options) ?>
    </div>
    <div style="margin-top: 5px">
    <?= Html::a('Andere Zufallsbilder generieren', '') ?>
    </div>
    <?php Pjax::end(); ?>
    <?= Markdown::convert(Html::encode($model->description))?>
    
</div>

<h2><a name="disqus_thread">Diskussionen zur Kampagne</a></h2>
<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES * * */
    var disqus_shortname = 'pnauw';
    var disqus_identifier = '/campaign/<?= $model->id ?>';
    var disqus_url = '<?= Url::to(['campaign/show','id'=> $model->id],true)?>';
    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
