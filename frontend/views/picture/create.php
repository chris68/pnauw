<?php
/* @var $this yii\web\View */
/* @var $model frontend\models\Picture */

use yii\helpers\Html;

$this->title = 'Direktanlage'.(Yii::$app->user->can('anonymous')?' (Anonym)':'');
$this->params['breadcrumbs'][] = ['label' => 'Bild', 'url' => ['manage']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['help'] = 'picture-create';
?>
<div class="picture-create">

    <?php echo $this->render('_formtabbed', [
        'model' => $model,
        'outerform' => NULL,
    ]); ?>

</div>
