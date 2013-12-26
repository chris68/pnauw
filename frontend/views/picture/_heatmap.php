<?php
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

use yii;
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
						echo Yii::$app->getUrlManager()->createUrl('picture/geodata', $params);
					}
				  ?>";
</script>
<div class="row">
	<div class="col-lg-4" style="margin-top: 10px; margin-bottom: 10px;">
		<!-- The Google maps canvas needs absolute coordinates -->
		<div id="picture-heatmap-map-canvas" style="width: 300px; height: 300px;"></div>
	</div>
</div>
