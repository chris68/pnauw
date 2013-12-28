<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/**
 * @var \yii\web\View $this
 * @var string $content
 */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Plattform zum Dokumentieren von missbräuchlichen Parken auf Gehwegen, Radwegen und in verkehrsberuhigten Zonen">
	<title><?= $this->title ?></title>
	<?php $this->head() ?>
</head>
<body>
	<?php $this->beginBody() ?>
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
			['label' => \Yii::t('base','Home'), 'url' => ['/site/index']],
			[
				'label' => 'Moderieren', 
				'visible' => Yii::$app->user->checkAccess('moderator'),
				'items' => [
					['label' => 'Bilder', 'url' => ['/picture/moderate','sort'=>'modified_ts-desc']],
				],
			],
			[
				'label' => 'Bilder', 
				'visible' => !Yii::$app->user->isGuest,
				'items' => [
					['label' => 'Aufnehmen', 'url' => ['/picture/capture']],
					['label' => 'Hochladen', 'url' => ['/picture/upload'], 'visible' => !Yii::$app->user->checkAccess('anonymous'),],
					['label' => 'Ohne Bild anlegen', 'url' => ['/picture/create']],
					['label' => 'Bearbeiten', 'url' => ['/picture/manage','sort'=>'taken-desc']],
					['label' => 'Veröffentlichen', 'url' => ['/picture/publish','sort'=>'modified_ts-desc']],
					['label' => 'Anschauen', 'url' => ['/picture/index','sort'=>'taken-desc']],
				],
			],
			['label' => \Yii::t('base','About'), 'url' => ['/site/about']],
			['label' => \Yii::t('base','Contact'), 'url' => ['/site/contact']],
		];
		if (Yii::$app->user->isGuest) {
			$menuItems[] = ['label' => \Yii::t('base','Signup'), 'url' => ['/site/signup']];
			$menuItems[] = ['label' => \Yii::t('base','Login'), 'url' => ['/site/login']];
		} else {
			$menuItems[] = ['label' => \Yii::t('base','Logout').' (' . Yii::$app->user->identity->username .')' , 'url' => ['/site/logout']];
		}
		echo Nav::widget([
			'options' => ['class' => 'navbar-nav navbar-right'],
			'items' => $menuItems,
		]);
		NavBar::end();
	?>

	<div class="container">
	<?= Breadcrumbs::widget([
		'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
		'encodeLabels' => false,
	]) ?>
	<?= Alert::widget() ?>
	<?= $content ?>
	</div>

	<footer class="footer">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-12 alert alert-warning">
					Das System ist derzeit noch in Entwicklung und daher noch nicht für eine richtige Nutzung geeignet!
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6 col-md-6">
					<?= Html::a('Nutzungsbedingungen','site/terms') ?> |
					<?= Html::a('Impressum','site/impressum') ?> |
					<?= Html::a('Datenschutz','site/privacy') ?>
				</div>
				<div class="col-sm-2 col-md-2">
					<hr class ="visible-xs visible-sm">
				</div>
				<div class="col-sm-4 col-md-4">
					<p class ="pull-right"><?= Yii::powered() ?></p>
				</div>
			</div>
		</div>
	</footer>

	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
