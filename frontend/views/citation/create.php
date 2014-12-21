<?php

use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var frontend\models\Citation $model
 */

$this->title = 'Anzeige anlegen';
$this->params['breadcrumbs'][] = ['label' => 'Anzeigen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['help'] = 'citation-crud';
?>
<div class="citation-create">

    <h1><?= $this->title ?></h1>

    <?php echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
