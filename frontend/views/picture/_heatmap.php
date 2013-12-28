<?php
/* @var $this yii\web\View */
/* @var $private boolean */

use yii;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<?php
  \frontend\views\picture\assets\PictureHeatmapAsset::register($this);
?>

	
<script type="text/javascript">
		var heatmapSource = 
				"<?php 
					{
						$request = Yii::$app->getRequest();
						$params = $request instanceof yii\web\Request ? $request->get() : [];
						$params = ['private' => $private] + $params;
						echo Yii::$app->getUrlManager()->createUrl('picture/geodata', $params);
					}
				  ?>";
</script>
<div class="row">
	<div class="col-sm-4 col-md-4 col-lg-4 form-group" style="margin-top: 10px; margin-bottom: 10px;">
			<input type="text" id="picture-heatmap-search-address" class="form-control" style="margin-bottom: 5px" autocomplete="off" placeholder="Kartensuche">
			<p><a href="#goto_current_geolocation" id="picture-heatmap-goto-current-geolocation">Zum aktuellen GPS-Standort navigieren</a></p>
			
		<!-- The Google maps canvas needs absolute coordinates -->
		<div id="picture-heatmap-map-canvas" style="width: 300px; height: 300px;"></div>
	</div>
</div>
