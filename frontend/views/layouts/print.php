<?php
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AppAsset;

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
	<link rel="icon" type="image/x-icon" href="<?=Url::to('favicon.ico')?>">
	<title><?= $this->title ?></title>
	<?php $this->head() ?>
</head>
<body>
	<?php $this->beginBody() ?>

	<div class="container">
	<?= $content ?>
	</div>

	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
