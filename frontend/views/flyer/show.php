<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\markdown\Markdown;
use frontend\controllers\PictureController;
use Imagick;
use ImagickDraw;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var frontend\models\Flyer $model
 */

$this->title = Html::encode($model->name);
$this->params['breadcrumbs'][] = 'Zettel';
$this->params['breadcrumbs'][] = Html::encode($model->name);
$this->params['help'] = 'flyer-show';
?>
<div class="flyer-view">

    
    <h1><?= $this->title ?></h1>
    <a href="#disqus_thread">Diskussionen</a> |
    <?= Html::a('Kontakt aufnehmen', ['site/contact','context'=>'Zettel: '.$model->id], ['target' => '_blank']) ?> |
    <?= ((yii::$app->user->can('isObjectOwner', array('model' => $model)))?(' | '.Html::a('Zettel bearbeiten', ['flyer/update','id'=>$model->id], ['target' => '_blank'])):'') ?>
    <?= Markdown::convert(Html::encode($model->description))?>
    
</div>

<h2><a name="disqus_thread">Diskussionen zum Zettel</a></h2>
<div id="disqus_thread"></div>
<script type="text/javascript">
    /* * * CONFIGURATION VARIABLES * * */
    var disqus_shortname = 'pnauw';
    var disqus_identifier = '/flyer/<?= $model->id ?>';
    var disqus_url = '<?= Url::to(['flyer/show','id'=> $model->id],true)?>';
    /* * * DON'T EDIT BELOW THIS LINE * * */
    (function() {
        var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
        dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
        (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript" rel="nofollow">comments powered by Disqus.</a></noscript>
