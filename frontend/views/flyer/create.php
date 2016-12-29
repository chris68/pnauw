<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\models\Flyer $model
 */

$this->title = 'Zettel anlegen';
$this->params['breadcrumbs'][] = ['label' => 'Zettel', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['help'] = 'flyer-crud';
?>
<div class="flyer-create">

    <h1><?= $this->title ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
