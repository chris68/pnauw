<?php
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\captcha\Captcha;

$this->title = \Yii::t('base','Contact');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-contact">
	<h1><?= $this->title ?></h1>

	<p>
		<?= \Yii::t('base','If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.')?>
	</p>

	<div class="row">
		<div class="col-lg-5">
			<?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
				<?= $form->field($model, 'name') ?>
				<?= $form->field($model, 'email') ?>
				<?= $form->field($model, 'subject') ?>
				<?= $form->field($model, 'body')->textArea(['rows' => 6]) ?>
				<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
					'options' => ['class' => 'form-control'],
					'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
				]) ?>
				<div class="form-group">
					<?= Html::submitButton(\Yii::t('base','Submit'), ['class' => 'btn btn-primary']) ?>
				</div>
			<?php ActiveForm::end(); ?>
		</div>
	</div>

</div>
