<?php
/* @var $this yii\web\View */
/* @var $private boolean */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

?>

<?php
  \frontend\views\picture\assets\PictureHeatmapAsset::register($this);
?>

	
<script type="text/javascript">
		var heatmapSource = 
		"<?php 
			{
				echo Url::toRoute(array_replace_recursive(['picture/geodata'], Yii::$app->getRequest()->get(), ['private' => $private]));
			}
		  ?>";
</script>
<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4 form-group" style="margin-top: 10px; margin-bottom: 10px;">
		<input type="text" id="picture-heatmap-search-address" class="form-control" style="margin-bottom: 5px" autocomplete="off" placeholder="Kartensuche">
			
		<!-- The Google maps canvas needs absolute coordinates -->
		<div id="picture-heatmap-map-canvas" style="width: 300px; height: 300px;"></div>
	</div>
</div>
