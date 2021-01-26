<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\markdown\Markdown;
use yii\helpers\HtmlPurifier;
use frontend\controllers\PictureController;
use frontend\models\PictureSearch;
use Imagick;
use ImagickDraw;
use yii\widgets\Pjax;

 /* @var $this yii\web\View */
 /* @var $model frontend\models\Flyer */
 
$this->title = 'Zettel '.Html::encode($model->secret);
$this->params['breadcrumbs'][] = 'Zettel';
$this->params['breadcrumbs'][] = Html::encode($model->secret);
$this->params['help'] = 'flyer-show';
?>
<div class="flyer-view">

    
    <div class="alert alert-info alert-dismissable" style="margin-top: 10px">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        Wenn Sie das erste Mal hier sind, dann lesen Sie sich am besten auch die <a href="<?= Url::to(['site/about']) ?>">Hintergrundsinfos</a> durch. Dort ist kurz und knackig erklärt, was es mit dieser Webseite auf sich hat.
    </div>
    <a href="#disqus_thread">Diskussionen</a>

    <?php
        if ((!empty($model->running_from)&&!empty($model->loc_filter))) {
            $stack = new Imagick();
            /* var $pic frontend\models\Picture */
            $searchModel = new PictureSearch(['scenario' => 'public']);
            $searchModel->loc_formatted_addr = $model->loc_filter;
            $searchModel->time_range = $model->running_from.';'.$model->running_until;
            $dataProvider = $searchModel->search(NULL);
            $dataProvider->query->publicScope();
            $dataProvider->query->andWhere(['is not','blurred_thumbnail_image_id',NULL]);
            $dataProvider->query->limit(9);

            $dataProvider->query->orderBy(['random()' => SORT_DESC,]);

            $stack_count = 0;
            foreach ($dataProvider->getModels() as $pic) {
                $thumb = new Imagick();
                if (isset($pic->blurredThumbnailImage)) {
                    $imageBlob = hex2bin(stream_get_contents($pic->blurredThumbnailImage->rawdata, -1, 0));
                    $thumb->readImageBlob($imageBlob);
                    $stack->addImage($thumb); ++$stack_count;
                }
            }
            if ($stack_count > 0) {
                $montage = $stack->montageImage(new ImagickDraw(), '3x3', '', 0, '0');
                $montage->setImageFormat('jpg');
                
                $montage_options = array();
                $montage_options['src'] = 'data:image/jpg;base64,' . base64_encode($montage->getImageBlob());
                $montage_options['alt'] = 'Vorfälle zum Zettel';
    ?>
    <?php Pjax::begin(['id' => 'samplepics', 'enablePushState' => false, 'timeout' => 10000, ]); ?>

    <div style="margin-top: 10px">
    <?= \yii\helpers\Html::tag('img','',$montage_options) ?>
    </div>
    <div style="margin-top: 5px">
    <?= Html::a('Andere Zufallsbilder generieren', '') ?>
    </div>
    <?php Pjax::end(); ?>
    <?php
            } 
        }
    ?>

    <?= HtmlPurifier::process(Markdown::convert($model->description))?>
    
    <div style="margin-top: 5px">
    <?= Html::a('Kontakt aufnehmen', ['contact','id'=>$model->id], ['target' => '_blank']) ?>
    <?= (!empty($model->running_from)&&!empty($model->loc_filter))?' | '.Html::a('Alle Vorfälle zum Zettel anschauen', ['picture/index', 's[time_range]' => $model->running_from.';'.$model->running_until, 's[loc_formatted_addr]' => $model->loc_filter, 's[map_bind]' => '1'], ['target' => '_blank']):'' ?>
    <?= ((yii::$app->user->can('isObjectOwner', array('model' => $model)))?(' | '.Html::a('Zettel bearbeiten', ['flyer/update','id'=>$model->id], ['target' => '_blank'])):'') ?>
    | <?= Html::a('Zettel drucken',['flyer/print','secret' => $model->secret], ['target' => '_blank'] ) ?>
    <?= !Yii::$app->user->isGuest?(' | '.Html::a('Zettel kopieren', ['copy', 'secret' => $model->secret] )):'' ?>
    </div>
</div>

<h2><a name="disqus_thread">Diskussionen zum Zettel</a></h2>
<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES * * */
    var disqus_shortname = 'pnauw';
    var disqus_identifier = '/flyer/<?= $model->secret ?>';
    var disqus_url = '<?= Url::to(['flyer/show','secret'=> $model->secret],true)?>';
    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
