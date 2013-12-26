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

<div id="picture-heatmap-map-canvas" style="margin-top: 10px; margin-bottom: 10px; border: 1px dashed #C0C0C0; width: 300px; height: 300px;"></div>

