<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;

// @chris68
use yii\helpers\Url;
/*
 * Register cooking consent according to https://cookieconsent.insites.com
 */
$this->registerCssFile('https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.css');
$this->registerJsFile('https://cdnjs.cloudflare.com/ajax/libs/cookieconsent2/3.0.3/cookieconsent.min.js');
    $codeJs = '
window.addEventListener("load", function(){
window.cookieconsent.initialise({
  "palette": {
    "popup": {
      "background": "#eaf7f7",
      "text": "#5c7291"
    },
    "button": {
      "background": "#56cbdb",
      "text": "#ffffff"
    }
  },
  "content": {
    "message": "Diese Webseite nutzt Cookies, für deren Einsatz die EU ihr Einverständnis verlangt",
    "dismiss": "Verstanden",
    "link": "Details",
    "href": "'.Url::to(['site/privacy']).'"
  }
})});
';
$this->registerJs($codeJs);

AppAsset::register($this);
?>
    <?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Plattform zum Dokumentieren von missbräuchlichen Parken auf Gehwegen, Radwegen und in verkehrsberuhigten Zonen">
    <?= Html::csrfMetaTags() ?>
    <link rel="icon" type="image/x-icon" href="<?=Url::to('favicon.ico')?>">
    <title><?= $this->title ?></title>
    <?php $this->head() ?>
</head>
<body>
    <?php if (Yii::$app->user->isGuest) : // Enable google analytics only when not logged in ?>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-46784417-1', 'parke-nicht-auf-unseren-wegen.de');
      ga('send', 'pageview');

    </script>
    <?php endif ?>

    <?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                // Label should be small; otherwise on mobile phone the navbar blows up to two lines!
                'brandLabel' => '<small>Parke nicht auf unseren Wegen</small>',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            $menuItems = [
                ['label' => \Yii::t('base','Home'), 'url' => Yii::$app->homeUrl],
                [
                    'label' => 'Moderieren', 
                    'visible' => Yii::$app->user->can('moderator'),
                    'items' => [
                        ['label' => 'Bilder', 'url' => ['/picture/moderate']],
                    ],
                ],
                [
                    'label' => 'Bilder', 
                    'visible' => !Yii::$app->user->isGuest,
                    'items' => [
                        ['label' => 'Direktanlage', 'url' => ['/picture/create']],
                        ['label' => 'Aufnehmen', 'url' => ['/picture/capture']],
                        ['label' => 'Hochladen', 'url' => ['/picture/upload']],
                        ['label' => 'Von FTP übernehmen', 'url' => ['/picture/serverupload'], 'visible' => Yii::$app->user->can('canUploadFromServer')],
                        ['label' => 'Aus KML-Datei übernehmen', 'url' => ['/picture/kmlupload'], 'visible' => Yii::$app->user->can('canUploadFromServer')],
                        ['label' => 'Bearbeiten', 'url' => ['/picture/manage']],
                        ['label' => 'Veröffentlichen', 'url' => ['/picture/publish']],
                        ['label' => 'Anschauen', 'url' => ['/picture/index']],
                    ],
                ],
                [
                    'label' => 'Bilder',
                    'visible' => Yii::$app->user->isGuest,
                    'items' => [
                        ['label' => 'Direktanlage (als Gast)', 'url' => ['/picture/guestcreate']],
                        ['label' => 'Aufnehmen (als Gast)', 'url' => ['/picture/guestcapture']],
                        ['label' => 'Hochladen (als Gast)', 'url' => ['/picture/guestupload']],
                        ['label' => 'Anschauen', 'url' => ['/picture/index']],
                    ],
                ],
                [
                    'label' => 'Verwalten', 
                    'visible' => !Yii::$app->user->isGuest,
                    'items' => [
                        ['label' => 'Kampagnen', 'url' => ['/campaign/index'], 'visible' => Yii::$app->user->can('trusted')],
                        ['label' => 'Anzeigen', 'url' => ['/citation/index']],
                        '<li class="divider"></li>',
                        ['label' => 'Nutzerdaten', 'url' => ['/site/userdata']],
                        ['label' => 'Fremdlogins', 'url' => ['/site/foreignlogin']],
                    ],
                ],
                ['linkOptions' => ['target' => '_blank'], 'label' => 'Hilfe', 'url' => ['/site/help'.(isset($this->params['help']) ? ('#'.$this->params['help']) : ''), ],],
                ['label' => \Yii::t('base','About'), 'url' => ['/site/about']],
                ['label' => \Yii::t('base','Contact'), 'url' => ['/site/contact']],
            ];
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => \Yii::t('base','Signup'), 'url' => ['/site/signup']];
                $menuItems[] = ['label' => \Yii::t('base','Login'), 'url' => ['/site/login']];
            } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                \Yii::t('base','Logout').' (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
        ?>

        <div class="container">
        <?php if (isset($this->params['breadcrumbs'])) : ?>
        <ul class="breadcrumb">
            <?= Breadcrumbs::widget([
                'links' => $this->params['breadcrumbs'],
                'encodeLabels' => false,
                'tag' => 'span',
            ]) ?>
            <li style="float:right"><?= Html::a('Hilfe', ['/site/help'.(isset($this->params['help']) ? ('#'.$this->params['help']) : ''), ], ['target' => '_blank'] ) ?> </li>
        </ul>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
        </div>
    </div>
    
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-md-6" style='font-size:x-small'>
                    <?= Html::a('Nutzungsbedingungen',['site/terms']) ?> |
                    <?= Html::a('§55 RStV',['site/impressum']) ?> |
                    <?= Html::a('Datenschutz',['site/privacy']) ?>
                </div>
            </div>
        </div>
    </footer>

    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
