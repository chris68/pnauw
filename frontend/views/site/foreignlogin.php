<?php
use yii\helpers\Html;
use yii\widgets\ListView;
use frontend\helpers\Assist;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\UserdataForm */

$this->title = 'Fremdlogins verwalten';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="site-foreignlogin">
    <h1><?= $this->title ?></h1>

    <h3>Verbindung zu einem Konto herstellen</h3>
    <p>Hier können Sie eine Login-Verbindung zu einem Konto der unten aufgeführten <?=Assist::extlink('OAuth', 'http://de.wikipedia.org/wiki/OAuth') ?>-Provider herstellen. Sie können sich dann immer auch über den Login dieses Providers anmelden.</p>
    <p>Außer der Emailadresse und sehr globalen Profildaten rufen wir hierbei nichts ab und maximal die Emailadresse bzw. der Name wird bei uns gespeichert, damit Sie später unten erkennen können, mit welchen Account Sie sich verbunden haben.</p>

    <?= yii\authclient\widgets\AuthChoice::widget([
         'baseAuthUrl' => ['site/auth'],
         'popupMode' => false,
    ]) ?>

    <h3>Aktuell verbundene Konten</h3>
    <p>Mit folgenden Konten der entsprechenden Provider sind sie momentan verbunden.</p>
    <ul class="auth-clients clear">
    <?php echo ListView::widget([
        'dataProvider' => $dataProvider,
        'layout' => "{items}\n",
        'itemView' => function ($model, $key, $index, $widget) {
            return '<li class="auth-clients"><span class="auth-icon '.$model->source.'"></span>'.$model->source_name.' </li>';
        },
    ]); ?>
    </ul>
    <div style="color:#999;margin:1em 0">
        Sie können jederzeit hier <?= Html::a('alle Verbindungen zurücksetzen', ['site/foreignlogin','delete' => 'ALL']) ?>, um diese Fremd-Logins nicht mehr zu ermöglichen.
    </div>
</div>
