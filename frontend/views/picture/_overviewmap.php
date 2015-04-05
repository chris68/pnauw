<?php
/* @var $this yii\web\View */
/* @var $private boolean */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;

?>

<?php
  \frontend\views\picture\assets\PictureOverviewmapAsset::register($this);
?>

    
<script type="text/javascript">
        var overviewmapSource =
        "<?php 
            {
                echo Url::toRoute(array_replace_recursive(['picture/geodata'], Yii::$app->getRequest()->get(), ['private' => $private]));
            }
          ?>";
</script>
<div class="row">
    <div class="col-sm-4 col-md-4 col-lg-4 form-group" style="margin-top: 10px; margin-bottom: 10px;">
        <div id="overviewmap" style="height: 300px;"></div>
    </div>
</div>
