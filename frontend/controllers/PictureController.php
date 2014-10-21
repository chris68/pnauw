<?php

namespace frontend\controllers;

use frontend\models\Picture;
use frontend\models\PictureSearch;
use frontend\models\PictureUploadForm;
use frontend\models\PictureCaptureForm;
use frontend\models\PictureModerateForm;
use frontend\models\PicturePublishForm;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\web\HttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\helpers\Html;
use yii\helpers\FileHelper;
use yii\base\InvalidParamException;
use frontend\helpers\Assist;

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
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['index','geodata','guestcapture', 'guestupload', 'view', 'massview'],
					],
					[
						'allow' => false,
						'actions' => ['serverupload',],
						'roles' => ['anonymous'],
					],
					[
						'allow' => true,
						'actions' => ['manage', 'create', 'update', 'delete', 'massupdate', 'upload', 'capture', 'publish'],
						'roles' => ['@'],
					],
					[
						'allow' => true,
						'actions' => ['moderate', 'serverupload'. ],
						'roles' => ['moderator'],
					],
				],
			],
		];
	}

	/**
	 * Lists Picture models according to search.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new PictureSearch(['scenario' => 'public']);
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		$dataProvider->query->publicScope();
		$dataProvider->sort->defaultOrder = ['id' => SORT_DESC,];
		$dataProvider->pagination->pageSize = 20;

		return $this->render('index', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
		]);
	}

	/**
	 * Returns the geodata according to search.
	 * Only a limited number of points will be returned. 
	 * search parameter map_bounds
	 * The ones closest to the center of a map boundary (search parameter map_bounds) will be return first (i.e. the order is the distance to the center of the map
	 * @param boolean $private Shall only the private data be returned? This is needed since currently it is still impossible to pass that property safely via the search parameter
	 * @return mixed
	 */
	public function actionGeodata($private=false)
	{
		// Differentiate whether we do a public or private search
		if ($private == false || Yii::$app->user->isGuest) {
			if 	(Yii::$app->user->can('moderator')) {
				// A moderator may use some more attributes for the search
				$searchModel = new PictureSearch(['scenario' => 'moderator']);
			} else {
				$searchModel = new PictureSearch(['scenario' => 'public']);
			}
				
		} else {
			$searchModel = new PictureSearch(['scenario' => 'private']);
		}
		
		$searchModel->load(Yii::$app->request->get());
		
		// Do not bind the search to the map if the geodata search shall not be limited to the map bounds
		if (!$searchModel->map_limit_points) {
			$searchModel->map_bind = false;
		}

		// Retrieve the center of the current map bounds
		if (!empty($searchModel->map_bounds)) {
			$corners = explode(',',$searchModel->map_bounds); // Format: "lat_lo,lng_lo,lat_hi,lng_hi"
			$lat = ((float)$corners[0]+(float)$corners[2])/2;
			$lng = ((float)$corners[1]+(float)$corners[3])/2;
		}
		else
		{
			// If we do not have map bounds then Karlsruhe Palace is assumed to be the center of the world :=)
			$lat = 49.0158491;
			$lng = 8.4095339;
			 
		}
		
		// Ultrafast and efficient data fetch!
		$query = Picture::find();
		// @Todo: Waiting for fix https://github.com/yiisoft/yii2/issues/1955 to use parameters
		$query->select(["tbl_picture.id", "tbl_picture.loc_lng", "tbl_picture.loc_lat", "tbl_incident.severity", "earth_distance( ll_to_earth(({$lat}), ({$lng}) ), ll_to_earth({{%picture}}.{{loc_lat}},{{%picture}}.{{loc_lng}})) as dist"]);
		//$query->select(["tbl_picture.id", "tbl_picture.loc_lng", "tbl_picture.loc_lat", "tbl_incident.severity", "earth_distance( ll_to_earth((:lat), (:lng) ), ll_to_earth({{%picture}}.{{loc_lat}},{{%picture}}.{{loc_lng}})) as dist"]);
		//$query->from ('tbl_picture');
		$query->innerJoin('tbl_incident','tbl_picture.incident_id=tbl_incident.id');
		// First sort for the year to cluster the data and then according to the distance
		// So it least for the most current year in the search we should see good data! 
		$query->orderBy(['extract(year from taken)' => SORT_DESC, 'dist' => SORT_ASC]);
		//$query->addParams([':lat' => $lat, ':lng' => $lng]);
		$query->asArray();

		// Set the scope according to the mode/authorizations
		if ($private == false || Yii::$app->user->isGuest) {
			$query->publicScope(); 
		} else {
			$query->ownerScope();
		}
		
		$dataProvider = $searchModel->search(NULL, $query);
		
		$dataProvider->pagination->pageSize = 2000; // maximum 2000 items
		$dataProvider->sort = false; // no sorting - even if the URL requires it!
		
		Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		
		$coords = [];
		foreach ($dataProvider->getModels() as $pic) {
			// Only return coordinates that have been fixed already and not (0,0)
			if ($pic['loc_lat'] <> '0' && $pic['loc_lng'] <> '0' ) {
				$coords[] = ['location'=>['lat'=>$pic['loc_lat'],'lng'=>$pic['loc_lng'],],'severity'=>$pic['severity'],'dist'=>$pic['dist']];
			}
		}
		return $coords;
	}

	/**
	 * Manage your own Picture models according to search.
	 * @param boolean $withPublish Change the visibility_id exactly like in publish; this is to support faster processing
	 * @return mixed
	 */
	public function actionManage($withPublish=false)
	{
		$result = ['deleted' => ['ok' => 0, 'nok' => 0],'updated' => ['ok' => 0, 'nok' => 0]];
		
		if (Yii::$app->request->isPost && (Yii::$app->request->post('Picture') !== NULL)) {
			$pics = [];
			foreach (Yii::$app->request->post('Picture') as $id => $post_pic) {
				$pics[$id] = new Picture();
			}
			\yii\base\Model::loadMultiple($pics, Yii::$app->request->post());
			foreach ($pics as $id => $form_pic) {
				$model = $this->findModel((int) $id);
				
				if (!Yii::$app->user->can('isObjectOwner', array('model' => $model))) {
					throw new HttpException(403, \Yii::t('common', 'You are not authorized to perform this action'));
				}
				
				if ($form_pic->deleted) {
					$count = $model->delete();
					if ($count === false) {
						$result['deleted']['nok']++;
					} else {
						$result['deleted']['ok'] += $count;
					}
				} else
				{
					if (
						$model->name <> $form_pic->name 
						|| $model->description <> $form_pic->description
						|| $model->incident_id <> $form_pic->incident_id
						|| $model->action_id <> $form_pic->action_id
						|| $model->campaign_id <> $form_pic->campaign_id
						|| $model->citation_id <> $form_pic->citation_id
						|| $model->citation_affix <> $form_pic->citation_affix
						|| $model->visibility_id <> $form_pic->visibility_id
					) {
						$model->name = $form_pic->name;
						$model->description = $form_pic->description;
						$model->incident_id = $form_pic->incident_id;
						$model->action_id = $form_pic->action_id;
						$model->campaign_id = $form_pic->campaign_id;
						$model->citation_id = $form_pic->citation_id;
						$model->citation_affix = $form_pic->citation_affix;
						$model->visibility_id = $form_pic->visibility_id;
						$success = $model->save();
						if ($success === false) {
							$result['updated']['nok']++;
						} else {
							$result['updated']['ok']++;
						}
						;
					}
				}
			}
			if ($result['deleted']['ok']+$result['deleted']['nok']+$result['updated']['ok']+$result['updated']['nok'] == 0) {
				$messages['warning'][] = 'Es wurden keinerlei Änderungen übernommen, weil Sie nichts geändert hatten';
			} else {
				if ($result['deleted']['ok'] == 1) {
					$messages['success'][] = '1 Satz wurde gelöscht';
				} elseif ($result['deleted']['ok'] > 1) {
					$messages['success'][] = $result['deleted']['ok'].' Sätze wurden gelöscht';
				}
				if ($result['deleted']['nok'] == 1) {
					$messages['danger'][] = '1 Satz konnte nicht gelöscht werden';
					$type = 'danger';
				} elseif ($result['deleted']['nok'] > 1) {
					$messages['danger'][] = $result['deleted']['nok'].' Sätze konnten nicht gelöscht werden';
				}
				
				if ($result['updated']['ok'] == 1) {
					$messages['success'][] = '1 Satz wurde aktualisiert';
				} elseif ($result['updated']['ok'] > 1) {
					$messages['success'][] = $result['updated']['ok'].' Sätze wurden aktualisiert';
				}
				if ($result['updated']['nok'] == 1) {
					$messages['danger'][] = '1 Satz konnte wegen verletzter '.Assist::help('Konsistenzprüfungen','picture-consistency').' nicht aktualisiert werden und Ihre Änderungen wurden zudem verworfen.';
					$type = 'danger';
				} elseif ($result['updated']['nok'] > 1) {
					$messages['danger'][] = $result['updated']['nok'].' Sätze konnten wegen verletzter '.Assist::help('Konsistenzprüfungen','picture-consistency').' nicht aktualisiert werden und Ihre Änderungen wurden zudem verworfen';
				}
			}

			foreach ($messages as $key => $message) {
				if (count($message) > 0) {
					Yii::$app->session->setFlash($key,implode('<br> ',$message));
				}
			}
		}

		$searchModel = new PictureSearch(['scenario' => 'private']);
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		$dataProvider->query->ownerScope();
		$dataProvider->sort->defaultOrder = ['id' => SORT_ASC,];
		$dataProvider->pagination->pageSize = 20;

		return $this->render('manage', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
				'withPublish' => $withPublish,
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
		$model = new Picture(['scenario' => 'create']);
		$post_request = $model->load(Yii::$app->request->post());

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

		if ($model->load(Yii::$app->request->post()) && $model->save()) {
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
	 * If deletion is successful, the browser will be redirected to the 'manage' page, unless
	 * returl indicates that we are in massupdate. Then it will be redirected returl
	 * @param integer $id
	 * @param string $returl
	 * @return mixed
	 */
	public function actionDelete($id, $returl)
	{
		$this->findModel($id)->delete();
		if (strpos($returl,'/picture/massupdate') !== false) {
			return $this->redirect($returl);
		} 
		else {
			return $this->redirect(['manage']);
		}
	}

	/**
	 * Moderate Picture models according to search. 
	 * However, the search is always automatically limited to pics with visibility_id = public_approval_pending
	 * @return mixed
	 */
	public function actionModerate()
	{
		if (Yii::$app->request->isPost && Yii::$app->request->post('PictureModerateForm') !== NULL) {
			$pics = [];
			foreach (Yii::$app->request->post('PictureModerateForm') as $id => $post_pic) {
				$pics[$id] = new PictureModerateForm();
			}

			\yii\base\Model::loadMultiple($pics, Yii::$app->request->post());
			if (!\yii\base\Model::validateMultiple($pics)) {
				throw new HttpException(400, 'Incorrect input.');
			}

			foreach ($pics as $id => $form_pic) {
				$model = Picture::findOne((int) $id);
				$model->visibility_id = $form_pic->visibility_id;
				$model->save();
			}
		}

		// Force search parameter "visibility_id" to public_approval_pending since the moderator may see only pics with that status
		Yii::$app->getRequest()->setQueryParams(
			array_replace_recursive(Yii::$app->getRequest()->getQueryParams(),['s' => ['visibility_id' => 'public_approval_pending']]));
			
		$searchModel = new PictureSearch(['scenario' => 'moderator']);
		$searchModel->load(Yii::$app->request->get());
		// For utter security - set the parameter another time! Just in case something goes wrong above....
		$searchModel->visibility_id = 'public_approval_pending';
		$dataProvider = $searchModel->search(NULL);
		
		$dataProvider->query->publicScope();
		
		$dataProvider->sort->defaultOrder = ['id' => SORT_ASC,];
		$dataProvider->pagination->pageSize = 50;

		return $this->render('moderate', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
		]);
	}

	/**
	 * Publish Picture models according to search.
	 * However, the search is always automatically limited to pics with visibility_id = private
	 * @return mixed
	 */
	public function actionPublish()
	{
		if (Yii::$app->request->isPost && (Yii::$app->request->post('PicturePublishForm') !== NULL)) {
			$pics = [];
			foreach (Yii::$app->request->post('PicturePublishForm') as $id => $post_pic) {
				$pics[$id] = new PicturePublishForm();
			}

			\yii\base\Model::loadMultiple($pics, Yii::$app->request->post());
			if (!\yii\base\Model::validateMultiple($pics)) {
				throw new HttpException(400, 'Incorrect input.');
			}

			foreach ($pics as $id => $form_pic) {
				$model = Picture::findOne((int) $id);
				$model->visibility_id = $form_pic->visibility_id;
				$model->save();
			}
		}

		// Force search parameter "visibility_id" to private since publish mostly makes sense only for still private pictures
		Yii::$app->getRequest()->setQueryParams(
			array_replace_recursive(Yii::$app->getRequest()->getQueryParams(),['s' => ['visibility_id' => 'private']]));
			
		$searchModel = new PictureSearch(['scenario' => 'private']);
		$searchModel->load(Yii::$app->request->get());
		$dataProvider = $searchModel->search(NULL);
		
		$dataProvider->query->ownerScope();
		
		$dataProvider->sort->defaultOrder = ['id' => SORT_ASC,];
		$dataProvider->pagination->pageSize = 50;

		return $this->render('publish', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
		]);
	}

	/**
	 * Massview Picture models according to search.
	 * @return mixed
	 */
	public function actionMassview()
	{
		$searchModel = new PictureSearch(['scenario' => 'public']);
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		$dataProvider->query->publicScope();
		$dataProvider->sort->defaultOrder = ['id' => SORT_DESC,];
		$dataProvider->pagination->pageSize = 1;

		return $this->render('massview', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
		]);
	}

	/**
	 * Massupdate Picture models according to search.
	 * @return mixed
	 */
	public function actionMassupdate()
	{
		if (Yii::$app->request->isPost && (Yii::$app->request->post('Picture') !== NULL)) {
			$model = $this->findModel(Yii::$app->request->post('Picture')['id']); 

			if ($model->load(Yii::$app->request->post()) && $model->save()) {
				// Model has been saved => we can reload!
				$model = NULL;
			}
		} else {
			$model = NULL;
		}

		$searchModel = new PictureSearch(['scenario' => 'private']);
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		$dataProvider->query->ownerScope();
		$dataProvider->sort->defaultOrder = ['id' => SORT_ASC,];
		$dataProvider->pagination->pageSize = 1;

		return $this->render('massupdate', [
				'dataProvider' => $dataProvider,
				'searchModel' => $searchModel,
				'updatedmodel' => $model,
		]);
	}

	/**
	  Instant Capture Picture model (via anonymous user)
	 * @return mixed
	 */
	public function actionGuestcapture()
	{
		if (!Yii::$app->user->can('anonymous')) {
			return $this->enterGuestAccess();
		} 
		else {
			return $this->actionCapture();
		}
	}

	/**
	  Capture Picture model.
	 * @return mixed
	 */
	public function actionCapture()
	{
		$formmodel = new PictureCaptureForm();

		if ($formmodel->load(Yii::$app->request->post())) {
			$formmodel->file_handle = UploadedFile::getInstance($formmodel, 'file_name');
			if ($formmodel->validate()) {
				$transaction = Yii::$app->db->beginTransaction();
				try {
					$picmodel = new Picture(['scenario' => 'create']);
					$picmodel->fillFromFile($formmodel->file_handle->tempName);
					$transaction->commit();
				} catch (Exception $ex) {
					$transaction->rollback();
					throw($ex);
				}

				if ($formmodel->directEdit) {
					Yii::$app->session->setFlash('success', "Sie können das Bild nun bearbeiten.");
					return $this->redirect(['update', 'id' => $picmodel->id]);
				} else {
					Yii::$app->session->setFlash('success', 
						'Sie können das/die aufgenommenen Bilder nun '.
						Html::a('hier', ['massupdate', 's[created_ts]'=> date("Y-m-d"), 's[visibility_id]' => 'private']).
						' weiterverarbeiten. Alternativ können Sie natürlich auch weitere Bilder aufnehmen.');
					return $this->refresh();
				}
					
				
			}
		}

		return $this->render('capture', [
				'formmodel' => $formmodel,
		]);
	}

	/**
	  Instant Upload Picture model (via anonymous user)
	 * @return mixed
	 */
	public function actionGuestupload()
	{
		if (!Yii::$app->user->can('anonymous')) {
			return $this->enterGuestAccess();
		} 
		else {
			return $this->actionUpload();
		}
	}

	/**
	  Upload Picture model.
	 * @return mixed
	 */
	public function actionUpload($replicate=1)
	{
		$formmodel = new PictureUploadForm();

		if ($formmodel->load(Yii::$app->request->post())) {
			$formmodel->file_handles = UploadedFile::getInstances($formmodel, 'file_names');

			if ($formmodel->validate()) {
				for ($i=0;$i<(Yii::$app->user->can('admin')?((int)$replicate):1);$i++) {
				set_time_limit(120);
				$transaction = Yii::$app->db->beginTransaction();
				try {
					foreach ($formmodel->file_handles as $file) {
							$picmodel = new Picture(['scenario' => 'create']);
							$picmodel->fillFromFile($file->tempName);
					}
					$transaction->commit();
				} catch (Exception $ex) {
					$transaction->rollback();
					throw($ex);
				}
				
				}
				if (count($formmodel->file_handles) == 1) {
					$flash = 'Das eine Bild wurde problemlos eingelesen.<br>';
				} else {
					$flash = 'Die '.count($formmodel->file_handles).' Bilder wurden problemlos eingelesen.<br>';
					$flash = $flash.'<ul><li>Erstes Bild: '.$formmodel->file_handles[0]->name.'</li>';
					$flash = $flash.'<li>Letzes Bild: '.$formmodel->file_handles[count($formmodel->file_handles)-1]->name.'</li></ul>';
				}
				Yii::$app->session->setFlash('success', 
					$flash.
					'Sie können diese nun '.
					Html::a('hier', ['massupdate', 's[created_ts]'=> date("Y-m-d"), 's[visibility_id]' => 'private']).
					' weiterverarbeiten. Alternativ können Sie natürlich auch weitere Bilder hochladen.');
				return $this->refresh();
			}
		}

		return $this->render('upload', [
				'formmodel' => $formmodel,
		]);
	}

	/**
	 * Load the pictures from the server (usually a ftp access)
	 */
    public function actionServerupload()
    {
		if (Yii::$app->getRequest()->isPost) {
			$dir = Yii::$app->params['server-upload-dir'].'/'.Yii::$app->user->identity->username;
			if (!is_dir($dir) || 
				(count($files = FileHelper::findFiles(
					Yii::$app->params['server-upload-dir'].'/'.Yii::$app->user->identity->username,
					['recursive'=>false, 'only'=>['*.jpg']]
				)) == 0))
			{
				Yii::$app->session->setFlash('warning', 'Es liegen leider keine Dateien auf dem Server vor');
			} else
			{
				$transaction = Yii::$app->db->beginTransaction();
				try {
					foreach ($files as $filename) {
						$picmodel = new Picture(['scenario' => 'create']);
						$picmodel->fillFromFile($filename);
					}
					$transaction->commit();
				} catch (Exception $ex) {
					$transaction->rollback();
					throw($ex);
				}
				foreach ($files as $filename) {
					unlink ($filename);
				}
				Yii::$app->session->setFlash('success', 
					'Die '.count($files).' Bilder wurden problemlos eingelesen.<br>'.
					'Sie können diese nun '.
					Html::a('hier', ['massupdate', 's[created_ts]'=> date("Y-m-d"), 's[visibility_id]' => 'private']).
					' weiterverarbeiten. Alternativ können Sie natürlich auch weitere Bilder hochladen.');
			}
		}
		
		Render: return $this->render('serverupload');
    }

	/**
	 * Create a url to search for the campaign
	 * @param string $action The requested action (i.e. index, manage, etc)
	 * @param int $campaign_id The id of the campaign
	 * @return array The url ready to be used as parameter for e.g. Url::to
	 */
	public static function urlCampaign($action,$campaign_id) {
		return ["picture/$action", 's[campaign_id]' => $campaign_id];
	}
	
	/**
	 * Create a url to search for the vehicle registration plate
	 * @param string $action The requested action (i.e. index, manage, etc)
	 * @param int $vehicle The vehicle registration plate
	 * @return array The url ready to be used as parameter for e.g. Url::to
	 */
	public static function urlVehicleRegPlate($action,$vehicle_reg_plate) {
		return ["picture/$action", 's[vehicle_reg_plate]' => $vehicle_reg_plate];
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
		if (($model = Picture::findOne($id)) !== null) {
			if (Yii::$app->user->can('isObjectOwner', array('model' => $model))) {
				return $model;
			} else {
				throw new HttpException(403, \Yii::t('common', 'You are not authorized to perform this action'));
			}
		} else {
			throw new HttpException(404, 'The requested object does not exist or has been already deleted.');
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
		if (($model = Picture::findOne($id)) !== null) {
			return $model;
		} else {
			throw new HttpException(404, 'The requested page does not exist.');
		}
	}

	/**
	  Enter the guest access and then return the refreshed page
	 * @return mixed
	 */
	protected function enterGuestAccess()
	{
		// todo: Protocoll the ip address via Yii::$app->getRequest()->getUserIP()

		$model = new User();
		// Username and email blank will block login
		$model->username = '';
		$model->email = '';
		$model->role = User::ROLE_ANONYMOUS;
		// It will not be possible to log in another time - so the password does not matter...
		$model->password = '*'; 
        $model->generateAuthKey();
		if ($model->save(false) && Yii::$app->getUser()->login($model)) {
			// Reload to ensure the guest access is correctly visualized in the header
			return $this->refresh();
		} 
		else {
			throw new HttpException(500, 'Anonymous login did not work.');
		}
	}

}
