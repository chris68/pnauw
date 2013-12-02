<?php

namespace frontend\controllers;

use frontend\models\Picture;
use frontend\models\PictureSearch;
use frontend\models\PictureUploadForm;
use frontend\models\Image;
use yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\VerbFilter;
use yii\web\UploadedFile;
use Imagick;

/**
 * PictureController implements the CRUD actions for Picture model.
 */
class PictureController extends Controller
{

	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['post'],
				],
			],
			'access' => [
				'class' => \yii\web\AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	/**
	 * Lists all Picture models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new PictureSearch;
		$dataProvider = $searchModel->search($_GET);

		return $this->render('index', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
		]);
	}

	/**
	 * Displays a single Picture model.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
				'model' => $this->findModel($id),
		]);
	}

	/**
	 * Creates a new Picture model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Picture;

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('create', [
					'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing Picture model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load($_POST) && $model->save()) {
			return $this->redirect(['view', 'id' => $model->id]);
		} else {
			return $this->render('update', [
					'model' => $model,
			]);
		}
	}

	/**
	 * Deletes an existing Picture model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();
		return $this->redirect(['index']);
	}

	/**
	  Upload Picture model.
	 * @return mixed
	 */
	public function actionUpload()
	{
		$formmodel = new PictureUploadForm();
		$success = false;
		$formmodel = new PictureUploadForm();
		$picmodel = new Picture();

		if (isset($_POST['PictureUploadForm'])) {
			$formmodel->attributes = $_POST['PictureUploadForm'];

			if ($formmodel->validate()) {
				$file_count = count(UploadedFile::getInstances($formmodel, 'file_names'));
				if ($file_count > ini_get('max_file_uploads')) {
					$formmodel->addError('file_names', 'Sie können maximal ' . ini_get('max_file_uploads') . ' Dateien in einem Vorgang hochladen.');
				} else {

					$success = true;
					foreach (UploadedFile::getInstances($formmodel, 'file_names') as $file) {
						$picmodel = new Picture();
						$picmodel->upload__file_name = $file->name;
						$picmodel->upload__file_handle = $file;
						$picmodel->name = $file->name;
						$picmodel->taken = new \yii\db\Expression('NOW()');
						$picmodel->visibility_id = 'private';
						$picmodel->vehicle_country_code = 'D';
						$picmodel->clip_x = 50;
						$picmodel->clip_y = 50;
						$picmodel->clip_size = 25;


						if ($picmodel->validate()) {
							$transaction = \Yii::$app->db->beginTransaction();
							try {
								$props = exif_read_data($file->tempName);
								if (isset($props['GPSLatitude']) && isset($props['GPSLatitudeRef']) && isset($props['GPSLongitude']) && isset($props['GPSLongitudeRef'])) {
									$picmodel->org_loc_lat = $picmodel->loc_lat = $this->getGPS($props['GPSLatitude'], $props['GPSLatitudeRef']);
									$picmodel->org_loc_lng = $picmodel->loc_lng = $this->getGPS($props['GPSLongitude'], $props['GPSLongitudeRef']);
								} else {
									// If now coordinates exists set to 0,0 (nobody live there except for 'Ace Lock Service Inc' :=)
									$picmodel->org_loc_lat = $picmodel->loc_lat = 0;  
									$picmodel->org_loc_lng = $picmodel->loc_lng = 0; 
								}

								if (isset($props['DateTimeOriginal'])) {
									list($date, $time) = explode(' ', $props['DateTimeOriginal']); // 2011:09:17 10:36:00'
									$date = str_replace(':', '-', $date);
									$picmodel->taken = $date . ' ' . $time;
								} else {
									$picmodel->taken = NULL; // will result in an error!
								}

								$image = new Image;
								$rawdata = new Imagick($file->tempName);
								$this->autoRotateImage($rawdata);
								$image->rawdata = bin2hex($rawdata->getimageblob());
								$image->save(false);
								$picmodel->original_image_id = $image->id;

								$rawdata = new Imagick($file->tempName);
								$this->autoRotateImage($rawdata);
								$rawdata->profileimage('*', NULL); // Remove profile information
								$rawdata->scaleimage(75, 100);
								$image = new Image;
								$image->rawdata = bin2hex($rawdata->getimageblob());
								$image->save(false);
								$picmodel->thumbnail_image_id = $image->id;

								$rawdata->blurimage(3, 2);
								$image = new Image;
								$image->rawdata = bin2hex($rawdata->getimageblob());
								$image->save(false);
								$picmodel->blurred_thumbnail_image_id = $image->id;

								$rawdata = new Imagick($file->tempName);
								$this->autoRotateImage($rawdata);
								$rawdata->profileimage('*', NULL); // Remove profile information
								$rawdata->scaleimage(180, 240);
								$image = new Image;
								$image->rawdata = bin2hex($rawdata->getimageblob());
								$image->save(false);
								$picmodel->small_image_id = $image->id;

								$rawdata->blurimage(3, 2);
								$image = new Image;
								$image->rawdata = bin2hex($rawdata->getimageblob());
								$image->save(false);
								$picmodel->blurred_small_image_id = $image->id;

								$rawdata = new Imagick($file->tempName);
								$this->autoRotateImage($rawdata);
								$rawdata->profileimage('*', NULL); // Remove profile information
								$rawdata->scaleimage(375, 500);
								$image = new Image;
								$image->rawdata = bin2hex($rawdata->getimageblob());
								$image->save(false);
								$picmodel->medium_image_id = $image->id;

								$rawdata->blurimage(5, 3);
								$image = new Image;
								$image->rawdata = bin2hex($rawdata->getimageblob());
								$image->save(false);
								$picmodel->blurred_medium_image_id = $image->id;

								if (!$picmodel->save()) {
									$success = false;
									break;
								}

								$transaction->commit();
							} catch (Exception $ex) {
								$transaction->rollback();
								$success = false;
								throw($ex);
							}
						} else {
							$success = false;
						}
					}
				}
			}
		}

		if ($success) {
			// @Todo: Hier als link einfügen
			Yii::$app->session->setFlash('success', "<strong>Wunderbar</strong>, die {$file_count} Bilder wurden problemlos eingelesen und Sie können diese nun weiterverarbeiten. Alternativ können Sie natürlich auch weitere Bilder hochladen.");
			return $this->refresh();
		}

		return $this->render('upload', [
				'formmodel' => $formmodel,
				'picmodel' => $picmodel,
		]);
	}

	/**
	 * Finds the Picture model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Picture the loaded model
	 * @throws HttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Picture::find($id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}

	/**
	 * Resolve the rationale in the EXIF style GPS coordinate
	 * @param string $coordPart Exif Degree/Minute/Second
	 * @return float The respective float value 
	 * @link http://stackoverflow.com/questions/2526304/php-extract-gps-exif-data/2526412#2526412 Source
	 */
	private function gps2Num($coordPart)
	{
		$parts = explode('/', $coordPart);

		if (count($parts) <= 0)
			return 0;

		if (count($parts) == 1)
			return $parts[0];

		return floatval($parts[0]) / floatval($parts[1]);
	}

	/**
	 * Get the float representation of EXIF style GPS coordinates
	 * @param string $exifCoord Exif Longitude/Latitude
	 * @param array $hemi Exif LongitudeRef/LatitudeRef
	 * @return float The respective float value 
	 * @link http://stackoverflow.com/questions/2526304/php-extract-gps-exif-data/2526412#2526412 Source
	 */
	private function getGps($exifCoord, $hemi)
	{
		$degrees = count($exifCoord) > 0 ? $this->gps2Num($exifCoord[0]) : 0;
		$minutes = count($exifCoord) > 1 ? $this->gps2Num($exifCoord[1]) : 0;
		$seconds = count($exifCoord) > 2 ? $this->gps2Num($exifCoord[2]) : 0;

		$flip = ($hemi == 'W' or $hemi == 'S') ? -1 : 1;

		return $flip * ($degrees + $minutes / 60 + $seconds / 3600);
	}


	private function autoRotateImage($image)
	{
		$orientation = $image->getImageOrientation();

		switch ($orientation) {
			case imagick::ORIENTATION_BOTTOMRIGHT:
				$image->rotateimage("#000", 180); // rotate 180 degrees
				break;

			case imagick::ORIENTATION_RIGHTTOP:
				$image->rotateimage("#000", 90); // rotate 90 degrees CW
				break;

			case imagick::ORIENTATION_LEFTBOTTOM:
				$image->rotateimage("#000", -90); // rotate 90 degrees CCW
				break;
		}

		// Now that it's auto-rotated, make sure the EXIF data is correct in case the EXIF gets saved with the image!
		$image->setImageOrientation(imagick::ORIENTATION_TOPLEFT);
	}
}
