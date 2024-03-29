<?php

namespace frontend\controllers;

use frontend\models\Picture;
use frontend\models\PictureSearch;
use frontend\models\PictureUploadForm;
use frontend\models\PictureCaptureForm;
use frontend\models\PictureModerateForm;
use frontend\models\PicturePublishForm;
use frontend\models\PicturePrintForm;
use frontend\models\KmlUploadForm;
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
use yii\helpers\Url;

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
                        'actions' => ['index','geodata','guestcreate', 'guestcapture', 'guestupload', 'view', 'massview', 'contact'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['manage', 'create', 'update', 'delete', 'massupdate', 'upload', 'print', 'capture', 'publish', 'printmultiple', 'alpr'],
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['kmlupload', ],
                        'roles' => ['trusted'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['serverupload', ],
                        'roles' => ['canUploadFromServer'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['moderate', ],
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
        $dataProvider->query->andWhere(['not',['incident_id' => 20]]); // Do not show the satellite incidents here

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
            if     (Yii::$app->user->can('moderator')) {
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
            $corners = explode(',',$searchModel->map_bounds); // Format: "lng_lo,lat_lo,lng_hi,lat_hi"
            $lat = ((float)$corners[1]+(float)$corners[3])/2;
            $lng = ((float)$corners[0]+(float)$corners[2])/2;
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
        $query->select(["tbl_picture.id", "tbl_picture.loc_lng", "tbl_picture.loc_lat", "tbl_picture.incident_id", "tbl_incident.name as incident_name", "earth_distance( ll_to_earth(({$lat}), ({$lng}) ), ll_to_earth({{%picture}}.{{loc_lat}},{{%picture}}.{{loc_lng}})) as dist"]);
        //$query->select(["tbl_picture.id", "tbl_picture.loc_lng", "tbl_picture.loc_lat", "tbl_picture.incident_id", "earth_distance( ll_to_earth((:lat), (:lng) ), ll_to_earth({{%picture}}.{{loc_lat}},{{%picture}}.{{loc_lng}})) as dist"]);
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
                $coords[] = [
                    'type'=>'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates'=>[(double)$pic['loc_lng'],(double)$pic['loc_lat'],],
                    ],
                    'properties'=> [
                        'picture_id' => $pic['id'],
                        'incident_id' => $pic['incident_id'],
                        'incident_name' => $pic['incident_name'],
                    ],
                ];
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
        $defaultvalues = new Picture(['scenario' => 'defval']);

        if (Yii::$app->getRequest()->isPost)  {
            if ($defaultvalues->load(Yii::$app->request->post())) {
                if ($defaultvalues->validate()) {
                }
            } 
        } else {
            $defaultvalues->setDefaults();
            $defaultvalues->vehicle_country_code = '?';
        }

        $result = ['deleted' => ['ok' => 0, 'nok' => 0],'updated' => ['ok' => 0, 'nok' => 0]];
        
        if (Yii::$app->request->isPost && (Yii::$app->request->post('Picture') !== NULL)) {
            
            $models= Picture::find()->where(['id' => array_keys(Yii::$app->request->post('Picture'))])->indexBy('id')->all();
            \yii\base\Model::loadMultiple($models, Yii::$app->request->post());

            // Copy the defaults before validation
            foreach ($models as $id => $model) {
                if ($model->selected) {
                    $model->copyDefaults($defaultvalues);
                }
            }

            // Validation necessary that default and filter validators fire; otherwise getDirtyAttributes shows bogus changes!
            \yii\base\Model::validateMultiple($models);
            
            foreach ($models as $id => $model) {
                if (!Yii::$app->user->can('isObjectOwner', array('model' => $model))) {
                    throw new HttpException(403, \Yii::t('base', 'You are not authorized to perform this action'));
                }
                
                if ($model->deleted) {
                    $count = $model->delete();
                    if ($count === false) {
                        $result['deleted']['nok']++;
                    } else {
                        $result['deleted']['ok'] += $count;
                    }
                } else
                {
                    if (count($model->getDirtyAttributes()) > 0) {
                        $success = $model->save();
                        if ($success === false) {
                            $result['updated']['nok']++;
                        } else {
                            $result['updated']['ok']++;
                        }
                    } else {
                        /* Make sure that even unmodified models are touched, since otherwise they will not disappear from the worklist */
                        $model->touch('modified_ts');
                        $success = $model->save();
                        if ($success === false) {
                            $result['updated']['nok']++;
                        }
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
                'defaultvalues' => $defaultvalues,
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
     * If creation is successful, the browser will be redirected to the 'home' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Picture();
        $post_request = $model->load(Yii::$app->request->post());

        if (!$post_request) {
            // If it is the beginning of a create, set the default values
            $model->setDefaults();
            // If no coordinates exists set to 0,0 (nobody live there except for 'Ace Lock Service Inc' :=)
            $model->org_loc_lat = $model->loc_lat = 0;
            $model->org_loc_lng = $model->loc_lng = 0;

            // Since we are on the server (UTC) we just set it to date accurray; it will be ovveridden by the loval time from the client anyway
            $model->taken = date('Y-m-d') . ' 00:00:00';
        } else {
            if ($model->loc_lat == 0 && $model->loc_lng == 0) {
                // If no user defined position is given then take the original position
                $model->loc_lat = $model->org_loc_lat;
                $model->loc_lng = $model->org_loc_lng;
            }
        }

        if ($post_request && $model->validate()) {
            if (!empty($model->image_dataurl)) {
                $img = str_replace('data:image/jpeg;base64,', '', $model->image_dataurl);
                $blob = base64_decode($img);
            } else {
                $blob = NULL;
            }
            $transaction = Yii::$app->db->beginTransaction();
            try {
                if (isset($blob)) {
                    $model->fillFromBinary($blob);
                }
                $model->save(false);
                $transaction->commit();
            } catch (Exception $ex) {
                $transaction->rollback();
                throw($ex);
            }
            Yii::$app->session->setFlash('success', "Vorfall wurde angelegt. ".Html::a('Weiteren Vorfall erfassen', ['create']));
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
        $model = $this->findModelOwn($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Reload after save to make sure that all changes triggered in the db are incorporated
            $model = $this->findModelOwn($id);
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
        $this->findModelOwn($id)->delete();
        if (strpos($returl,'/picture/massupdate') !== false) {
            return $this->redirect($returl);
        } 
        else {
            return $this->redirect(['manage']);
        }
    }

    /**
     * Prints an existing Picture model.
     * @param integer $id
     * @return mixed
     */
    public function actionPrint($id)
    {
        $this->layout = 'print';
        return $this->render('print', [
            'model' => $this->findModelOwn($id),
        ]);
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
                $model->save(false,['visibility_id']);
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
            $model = $this->findModelOwn(Yii::$app->request->post('Picture')['id']);

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
     * Print picture models according to search.
     * @return mixed
     */
    public function actionPrintmultiple()
    {
        $searchModel = new PictureSearch(['scenario' => 'private']);
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $dataProvider->query->ownerScope();
        $dataProvider->sort->defaultOrder = ['vehicle_country_code' => SORT_ASC ,'vehicle_reg_plate'  => SORT_ASC, 'taken' => SORT_ASC, ];
        $dataProvider->pagination->pageSize = 500;
        
        $printParameters = new PicturePrintForm();
        $printParameters->load(Yii::$app->request->get());


        $this->layout = 'print';
        return $this->render('printmultiple', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'printParameters' => $printParameters,
        ]);
    }

    /**
      Instant Create Picture model (via anonymous user)
     * @return mixed
     */
    public function actionGuestcreate()
    {
        if (!Yii::$app->user->can('anonymous')) {
            return $this->enterGuestAccess();
        }
        else {
            return $this->actionCreate();
        }
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
                    $picmodel = new Picture(['scenario' => 'upload']);
                    $picmodel->fillFromFile($formmodel->file_handle->tempName);
                    $picmodel->save(false);
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
                        Html::a('hier', ['manage', 's[created_ts]'=> date("Y-m-d"), 's[visibility_id]' => 'private']).
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
        $defaultvalues = new Picture(['scenario' => 'defval']);
        $formmodel = new PictureUploadForm();

        if (Yii::$app->getRequest()->isPost) {
            if ($defaultvalues->load(Yii::$app->request->post()) && $defaultvalues->validate() && $formmodel->load(Yii::$app->request->post())) {
                $formmodel->file_handles = UploadedFile::getInstances($formmodel, 'file_names');

                if ($formmodel->validate()) {
                    for ($i=0;$i<(Yii::$app->user->can('admin')?((int)$replicate):1);$i++) {
                    set_time_limit(120);
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        foreach ($formmodel->file_handles as $file) {
                                $picmodel = new Picture(['scenario' => 'upload']);
                                $picmodel->fillFromFile($file->tempName,$defaultvalues);
                                $picmodel->save(false);
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
                        Html::a('hier', ['manage', 's[created_ts]'=> date("Y-m-d"), 's[visibility_id]' => 'private']).
                        ' weiterverarbeiten. Alternativ können Sie natürlich auch weitere Bilder hochladen.');
                    return $this->refresh();
                }
            }
        }
        else {
            $defaultvalues->setDefaults();
        }

        return $this->render('upload', [
                'formmodel' => $formmodel,
                'defaultvalues' => $defaultvalues,
        ]);
    }

    /**
      Upload a kml file
     * @return mixed
     */
    public function actionKmlupload()
    {
        $defaultvalues = new Picture(['scenario' => 'defval']);
        $formmodel = new KmlUploadForm();

        if (Yii::$app->getRequest()->isPost) {
            if ($defaultvalues->load(Yii::$app->request->post()) && $defaultvalues->validate() && $formmodel->load(Yii::$app->request->post())) {
                $formmodel->file_handles = UploadedFile::getInstances($formmodel, 'file_names');

                if ($formmodel->validate()) {
                    set_time_limit(120);
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        foreach ($formmodel->file_handles as $file) {
                            $dom = new \DOMDocument();
                            $dom->load($file->tempName);
                            $xpath = new \DOMXpath($dom);
                            $xpath->registerNamespace('kml', 'http://www.opengis.net/kml/2.2');

                            $places = $xpath->evaluate('//kml:Placemark', NULL, FALSE);
                            foreach ($places as $place) {
                                if ($xpath->evaluate('string(kml:Point)', $place, FALSE) <> '') {
                                    $coords = [$xpath->evaluate('string(kml:Point/kml:coordinates)', $place, FALSE)];
                                } elseif ($xpath->evaluate('string(kml:LineString)', $place, FALSE) <> '') {
                                    $coords = explode(' ', $xpath->evaluate('string(kml:LineString/kml:coordinates)', $place, FALSE));
                                } else {
                                    $coords = array();
                                }
                                foreach ($coords as $coord) {

                                    $point = explode(',', $coord, 2);

                                    $model = new Picture();
                                    $model->setDefaults();
                                    $model->org_loc_lat = $model->loc_lat = $point[1];
                                    $model->org_loc_lng = $model->loc_lng = $point[0];

                                    // Creation date is the date of the upload!
                                    $model->taken = date('Y-m-d') . ' 00:00:00';
                                    
                                    $model->copyDefaults($defaultvalues);

                                    $model->save(false);
                                }
                            }
                        }
                        $transaction->commit();
                    } catch (Exception $ex) {
                        $transaction->rollback();
                        throw($ex);
                    }

                    $flash = 'Die KML-Datei wurde eingelesen.<br>';

                    Yii::$app->session->setFlash('success',
                        $flash.
                        'Sie können die entsprechenden Vorfälle nun '.
                        Html::a('hier', ['manage', 's[created_ts]'=> date("Y-m-d")]).
                        ' weiterverarbeiten. Alternativ können Sie natürlich auch weitere KML-Dateien hochladen.');
                    return $this->refresh();
                }
            }
        }
        else {
            $defaultvalues->setDefaults();
            $defaultvalues->incident_id = 20; // Satellitenerfassung
            $defaultvalues->name = 'Erfassung über Satellitenbilder';
        }

        return $this->render('kmlupload', [
                'formmodel' => $formmodel,
                'defaultvalues' => $defaultvalues,
        ]);
    }

    /**
     * Load the pictures from the server (usually a ftp access)
     */
    public function actionServerupload()
    {
        ini_set('max_execution_time', 300); // Maximum 5 minutes 
        $defaultvalues = new Picture(['scenario' => 'defval']);

        $dir = Yii::$app->params['server-upload-dir'].'/'.Yii::$app->user->identity->username;
        if (!is_dir($dir) || 
            (count($files = FileHelper::findFiles(
                Yii::$app->params['server-upload-dir'].'/'.Yii::$app->user->identity->username,
                ['recursive'=>false/*, 'only'=>['*.jpg']*/] /* otherwise filenames like "Eisenbahnstra'$'\337''e 36.jpg" do not work */
            )) == 0)) {
            Yii::$app->session->setFlash('info', 'Es liegen keine Dateien auf dem Server vor');
        } else {
            Yii::$app->session->setFlash('info', 'Es liegen '.count($files).' Dateien auf dem Server vor. Die ersten 50 werden hochgeladen');
        }
        
        $files = array_slice($files, 0, 50); /* Limit to 50 files per upload */
        
         if (Yii::$app->getRequest()->isPost) {
            if ($defaultvalues->load(Yii::$app->request->post()) && $defaultvalues->validate()) {
                if (isset($files) && count($files) <> 0) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        foreach ($files as $filename) {
                            $picmodel = new Picture(['scenario' => 'upload']);
                            $picmodel->fillFromFile($filename,$defaultvalues);
                            $picmodel->save(false);
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
                        Html::a('hier', ['manage', 's[created_ts]'=> date("Y-m-d"), 's[visibility_id]' => 'private']).
                        ' weiterverarbeiten. Alternativ können Sie natürlich auch weitere Bilder hochladen.');
                }
                return $this->refresh();
            }
        }
        else {
            $defaultvalues->setDefaults();
        }
        
        return $this->render('serverupload', [
                'defaultvalues' => $defaultvalues,
        ]);
    }

    /**
     * Create a url to search for the campaign
     * @param string $action The requested action (i.e. index, manage, etc)
     * @param int $campaign_id The id of the campaign
     * @return array The url ready to be used as parameter for e.g. Url::to
     */
    public static function urlCampaign($action,$campaign_id) {
        return ["picture/$action", 's[campaign_id]' => $campaign_id, 's[map_bind]' => '1'];
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
    
    use ContactTrait;
    /**
     * Displays contact page for contacting the owner of the Picture model
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return mixed
     */
    public function actionContact($id)
    {
        return $this->contact($id,Url::to(['picture/view','id'=>$id],true));
    }

    /**
     * Action to make the automatic licence plate recognition
     * Two post parameter image (base64 encoded jpeg image) and country_code ('D','A', etc.) reguired
     * @return mixed The json response with {plate: xxxx} giving the plate or '?' if not sucessfull; errors are reported as {plate:"?", error:xxx}
     */
    public function actionAlpr() 
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $image=Yii::$app->request->post('image');
        $country_code=Yii::$app->request->post('country_code');

        if (empty($image)) {
            return ['error' => 'Base64 encoded image expected and not found','plate'=> '?'];
        }

        $file = tempnam(sys_get_temp_dir(), 'pnauw_alpr.');
        $file_jpeg = $file.'.jpeg';

        if( ! file_put_contents($file_jpeg, base64_decode($image) ) ){
            unlink($file);
            unlink($file_jpeg);
            return ['error' => 'Failed to save','plate'=> '?'];
        }

        $result = array();
        // Since calling alpr locally does not work anymore (since ubuntu 18.04) we use the web api in a quite dirty fashion - but it works...
        // @todo: Should be improved though...
        // exec('alpr --country eu --json -n 1 '.$file_jpeg,$result);
        exec("curl -X POST -F image=@".$file_jpeg." 'https://api.openalpr.com/v2/recognize?country=eu&output=json&secret_key=".Yii::$app->params['alpr.secretKey']."' ",$result);

        /* Delete both files */
        unlink($file);
        unlink($file_jpeg);

        /**
         * Check result.
         */
        if( empty( $result[0] ) ){
            return ['plate' => '?'];
        } else {
            $result_array = json_decode( $result[0], TRUE);
            $plate = isset($result_array['results'][0]['plate'])?$result_array['results'][0]['plate']:'?';
            $coordinates = isset($result_array['results'][0]['coordinates'])?$result_array['results'][0]['coordinates']:NULL;
            $img_width = $result_array['img_width'];
            $img_height = $result_array['img_height'];

            if ($coordinates) {
                // Calculate the middle point of the clip area as percentage and also the size
                $clip_x = (int)((min(array_column($coordinates , 'x'))+max(array_column($coordinates , 'x')))/$img_width*50);
                $clip_y = (int)((min(array_column($coordinates , 'y'))+max(array_column($coordinates , 'y')))/$img_height*50);
                $clip_size = (int)((max(array_column($coordinates , 'x'))-min(array_column($coordinates , 'x')))/$img_width*100)+3;
            } else {
                // If nothing found center with a quarter size
                $clip_x = 50; $clip_y = 50; $clip_size = 25;
            }
            
            switch ($country_code) {
                case 'D':
                    // Insert space after the reg_codes of the user
                    /* @var $user User */
                    $user = User::findIdentity(Yii::$app->user->getId());
                    if (!empty($user->appdata['reg_codes'])) {
                        $reg_codes = explode(',',$user->appdata['reg_codes']);
                        // Make sure we split of only correct plates (K AX 1333 vs KA X 13)
                        $reg_codes_regexp = array_map(function($value) { return '/^('.$value.')([A-ZÖÄÜ]{1,2}[0-9]{1,4})/'; },$reg_codes);
                        $plate = preg_replace($reg_codes_regexp,'$1 $2',$plate,1); 
                        // This handles the temp licence plates like GER 12345, etc. or police like BWL 4 4444 
                        $reg_codes_regexp = array_map(function($value) { return '/^('.$value.')([0-9]{1,6})/'; },$reg_codes);
                        $plate = preg_replace($reg_codes_regexp,'$1 $2',$plate,1); 
                    }
                    
                    // Insert space before trailing digits
                    $plate = preg_replace('/([0-9]+)$/',' $1',$plate); 
                    break;
                
            }
            
            return ['plate' => $plate,'clip_x'=>$clip_x, 'clip_y'=>$clip_y, 'clip_size'=>$clip_size, ];
        }
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
            return $model;
        } else {
            throw new HttpException(404, \Yii::t('The requested object does not exist or has been already deleted.'));
        }
    }

    use FindModelOwnTrait;

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
