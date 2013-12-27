<?php

namespace frontend\controllers;

use frontend\models\Picture;
use frontend\models\PictureSearch;
use frontend\models\PictureUploadForm;
use frontend\models\PictureCaptureForm;
use frontend\models\PictureModerateForm;
use frontend\models\PicturePublishForm;
use yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Html;

/**
 * PictureController implements CRUD actions and much more for Picture model.
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
						'actions' => ['index','geodata'],
					],
					[
						'allow' => true,
						'actions' => ['manage', 'create', 'update', 'delete', 'massupdate', 'upload', 'capture', 'publish'],
						'roles' => ['@'],
					],
					[
						'allow' => true,
						'actions' => ['moderate'],
						'roles' => ['moderator'],
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
		$searchModel = new PictureSearch(['scenario' => 'public']);
		$dataProvider = $searchModel->search($_GET);
		$dataProvider->query->publicScope();
		$dataProvider->pagination->pageSize = 20;

		return $this->render('index', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
		]);
	}

	/**
	 * Returns the geodata for the current picture search.
	 * @return mixed
	 */
	public function actionGeodata($private=false)
	{
		// Ultrafast and efficient data fetch!
		$query = Picture::find();
		$query->select('tbl_picture.id, tbl_picture.loc_lng, tbl_picture.loc_lat, tbl_incident.severity');
		$query->innerJoin('tbl_incident','tbl_picture.incident_id=tbl_incident.id');
		//$query->andWhere(['taken' => '2013-01-01']);
		$query->asArray();
		
		if ($private == false || Yii::$app->user->isGuest) {
			$query->publicScope(); 
			$searchModel = new PictureSearch(['scenario' => 'public']);
		} else {
			$query->ownerScope();
			$searchModel = new PictureSearch(['scenario' => 'private']);
		}
		
		$searchModel->load($_GET);
		if (!$searchModel->map_limit_points) {
			$searchModel->map_bounds = '';
		}
		$dataProvider = $searchModel->search(NULL, $query);
		
		$dataProvider->pagination->pageSize = 1000; // maximum 1000 items
		
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		$coords = [];
		foreach ($dataProvider->getModels() as $pic) {
			// Only return coordinates that have been fixed already and not (0,0)
			if ($pic['loc_lat'] <> '0' && $pic['loc_lng'] <> '0' ) {
				$coords[] = ['location'=>['lat'=>$pic['loc_lat'],'lng'=>$pic['loc_lng']],'severity'=>$pic['severity']];
			}
		}
		return $coords;
	}

	/**
	 * Manage your own Picture models.
	 * @return mixed
	 */
	public function actionManage()
	{
		if (\Yii::$app->request->isPost && isset($_POST['Picture'])) {
			$pics = [];
			foreach ($_POST['Picture'] as $id => $post_pic) {
				$pics[$id] = new Picture();
			}
			\yii\base\Model::loadMultiple($pics, $_POST);
			foreach ($pics as $id => $form_pic) {
				$model = $this->findModel((int) $id);
				
				if (!Yii::$app->user->checkAccess('isObjectOwner', array('model' => $model))) {
					throw new HttpException(403, \Yii::t('common', 'You are not authorized to perform this action'));
				}
				
				if ($form_pic->deleted) {
					$model->delete();
				} else
				{
					if (
						$model->name <> $form_pic->name 
						|| $model->description <> $form_pic->description
						|| $model->incident_id <> $form_pic->incident_id
						|| $model->action_id <> $form_pic->action_id
						|| $model->campaign_id <> $form_pic->campaign_id
						|| $model->citation_id <> $form_pic->citation_id
						|| $model->visibility_id <> $form_pic->visibility_id
					) {
						$model->name = $form_pic->name;
						$model->description = $form_pic->description;
						$model->incident_id = $form_pic->incident_id;
						$model->action_id = $form_pic->action_id;
						$model->campaign_id = $form_pic->campaign_id;
						$model->citation_id = $form_pic->citation_id;
						$model->visibility_id = $form_pic->visibility_id;
						$model->save();
					}
				}
			}
		}

		$searchModel = new PictureSearch(['scenario' => 'private']);
		$dataProvider = $searchModel->search($_GET);
		$dataProvider->query->ownerScope();
		$dataProvider->pagination->pageSize = 20;

		return $this->render('manage', [
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
		throw new HttpException(404, 'Sorry - aber derzeit ist es leider noch nicht möglich, die Bilder öffentlich anzuschauen!');
		return $this->render('view', [
				'model' => $this->findPublicModel($id),
		]);
	}

	/**
	 * Creates a new Picture model.
	 * If creation is successful, the browser will be redirected to the 'home' page.
	 * @return mixed
	 */
	public function actionCreate()
	{
		$model = new Picture;
		$post_request = $model->load($_POST);

		if (!$post_request) {
			// If it is the beginning of a create, set the default values
			$model->setDefaults();
			// If no coordinates exists set to 0,0 (nobody live there except for 'Ace Lock Service Inc' :=)
			$model->org_loc_lat = $model->loc_lat = 0;
			$model->org_loc_lng = $model->loc_lng = 0;
		}

		// We assume that the event was at the time of the creation of the "picture"!
		// However, we limit the accuracy to midnight of the day
		$model->taken = date('Y-m-d') . ' 00:00:00';
		// Need to set the org_loc_lat another time!
		$model->org_loc_lat = 0;
		$model->org_loc_lng = 0;

		if ($post_request && $model->save()) {
			Yii::$app->session->setFlash('success', "Bild wurde angelegt");
			return $this->redirect(['update', 'id' => $model->id]);
		}

		return $this->render('create', [
				'model' => $model,
		]);
	}

	/**
	 * Updates an existing Picture model.
	 * Success is shown via a flash message
	 * @param integer $id
	 * @return mixed
	 */
	public function actionUpdate($id)
	{
		$model = $this->findModel($id);

		if ($model->load($_POST) && $model->save()) {
			// Reload after save to make sure that all changes triggered in the db are incorporated
			$model = $this->findModel($id);
			Yii::$app->session->setFlash('success', "Änderung wurde übernommen");
		}

		return $this->render('update', [
				'model' => $model,
		]);
	}

	/**
	 * Deletes an existing Picture model.
	 * If deletion is successful, the browser will be redirected to the 'manage' page.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionDelete($id)
	{
		$this->findModel($id)->delete();
		return $this->redirect(['manage']);
	}

	/**
	 * Moderate all Picture models.
	 * @return mixed
	 */
	public function actionModerate()
	{
		if (\Yii::$app->request->isPost && isset($_POST['PictureModerateForm'])) {
			$pics = [];
			foreach ($_POST['PictureModerateForm'] as $id => $post_pic) {
				$pics[$id] = new PictureModerateForm();
			}

			\yii\base\Model::loadMultiple($pics, $_POST);
			if (!\yii\base\Model::validateMultiple($pics)) {
				throw new HttpException(400, 'Incorrect input.');
			}

			foreach ($pics as $id => $form_pic) {
				$model = Picture::find((int) $id);
				$model->visibility_id = $form_pic->visibility_id;
				$model->save();
			}
		}

		$searchModel = new PictureSearch(['scenario' => 'public']);
		$dataProvider = $searchModel->search($_GET);
		$dataProvider->pagination->pageSize = 50;
		$dataProvider->query->andWhere(['visibility_id' => 'public_approval_pending']);

		return $this->render('moderate', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
		]);
	}

	/**
	 * Publish all Picture models.
	 * @return mixed
	 */
	public function actionPublish()
	{
		if (\Yii::$app->request->isPost && isset($_POST['PicturePublishForm'])) {
			$pics = [];
			foreach ($_POST['PicturePublishForm'] as $id => $post_pic) {
				$pics[$id] = new PicturePublishForm();
			}

			\yii\base\Model::loadMultiple($pics, $_POST);
			if (!\yii\base\Model::validateMultiple($pics)) {
				throw new HttpException(400, 'Incorrect input.');
			}

			foreach ($pics as $id => $form_pic) {
				$model = Picture::find((int) $id);
				$model->visibility_id = $form_pic->visibility_id;
				$model->save();
			}
		}

		$searchModel = new PictureSearch(['scenario' => 'private']);
		$dataProvider = $searchModel->search($_GET);
		$dataProvider->pagination->pageSize = 50;
		$dataProvider->query->ownerScope();
		$dataProvider->query->andWhere(['visibility_id' => ['private']]);

		return $this->render('publish', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
		]);
	}

	/**
	 * Massupdate all Picture models.
	 * @return mixed
	 */
	public function actionMassupdate()
	{
		if (\Yii::$app->request->isPost && isset($_POST['Picture'])) {
			$model = $this->findModel($_POST['Picture']['id']);

			if ($model->load($_POST) && $model->save()) {
				// Model has been saved => we can reload!
				$model = NULL;
			}
		} else {
			$model = NULL;
		}

		$searchModel = new PictureSearch(['scenario' => 'private']);
		$dataProvider = $searchModel->search($_GET);
		$dataProvider->pagination->pageSize = 1;
		$dataProvider->query->ownerScope();

		return $this->render('massupdate', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
				'updatedmodel' => $model,
		]);
	}

	/**
	  Capture Picture model.
	 * @return mixed
	 */
	public function actionCapture()
	{
		$formmodel = new PictureCaptureForm();

		if ($formmodel->load($_POST)) {
			$formmodel->file_handle = UploadedFile::getInstance($formmodel, 'file_name');
			if ($formmodel->validate()) {
				$transaction = \Yii::$app->db->beginTransaction();
				try {
					$picmodel = new Picture;
					$picmodel->fillFromFile($formmodel->file_handle);
					$transaction->commit();
				} catch (Exception $ex) {
					$transaction->rollback();
					throw($ex);
				}

				Yii::$app->session->setFlash('success', "Sie können das Bild nun bearbeiten");
				return $this->redirect(['update', 'id' => $picmodel->id]);
			}
		}

		return $this->render('capture', [
				'formmodel' => $formmodel,
		]);
	}

	/**
	  Upload Picture model.
	 * @return mixed
	 */
	public function actionUpload($replicate=1)
	{
		$formmodel = new PictureUploadForm();

		if ($formmodel->load($_POST)) {
			$formmodel->file_handles = UploadedFile::getInstances($formmodel, 'file_names');

			if ($formmodel->validate()) {
				for ($i=0;$i<(Yii::$app->user->checkAccess('admin')?((int)$replicate):1);$i++) {
				set_time_limit(30);
				$transaction = \Yii::$app->db->beginTransaction();
				try {
					foreach ($formmodel->file_handles as $file) {
							$picmodel = new Picture;
							$picmodel->fillFromFile($file);
					}
					$transaction->commit();
				} catch (Exception $ex) {
					$transaction->rollback();
					throw($ex);
				}
				
				}

				Yii::$app->session->setFlash('success', 
					'<strong>Wunderbar</strong>, die ' . count($formmodel->file_handles) . 
					' Bilder wurden problemlos eingelesen und Sie können diese nun '.
					Html::a('hier', ['manage', 'PictureSearch[created_ts]'=> date("Y-m-d")]).
					' weiterverarbeiten. Alternativ können Sie natürlich auch weitere Bilder hochladen.');
				return $this->refresh();
			}
		}

		return $this->render('upload', [
				'formmodel' => $formmodel,
		]);
	}

	/**
	 * Finds the Picture model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * If the model is not owned by the user, a exception will be thrown
	 * @param integer $id
	 * @return Picture the loaded model
	 * @throws HttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Picture::find($id)) !== null) {
			if (Yii::$app->user->checkAccess('isObjectOwner', array('model' => $model))) {
				return $model;
			} else {
				throw new HttpException(403, \Yii::t('common', 'You are not authorized to perform this action'));
			}
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}

	/**
	 * Finds the Picture model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * All models regardless of the ownership are found
	 * @param integer $id
	 * @return Picture the loaded model
	 * @throws HttpException if the model cannot be found
	 */
	protected function findPublicModel($id)
	{
		if (($model = Picture::find($id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}

}
