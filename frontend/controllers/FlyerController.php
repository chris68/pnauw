<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Flyer;
use frontend\models\FlyerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Url;

/**
 * FlyerController implements the CRUD actions for Flyer model.
 */
class FlyerController extends Controller
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
                        'actions' => ['show','contact' ],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'copy', 'delete', 'print', 'qrcode'],
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Shows (for the public) a single Flyer model.
     * @param integer $secret
     * @return mixed
     */
    public function actionShow($secret)
    {
        return $this->render('show', [
            'model' => $this->findModelBySecret($secret),
        ]);
    }

    /**
     * Lists all Flyer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FlyerSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->get());
        $dataProvider->query->ownerScope();
        $dataProvider->sort->defaultOrder = ['id' => SORT_DESC,];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Flyer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModelOwn($id),
        ]);
    }

    /**
     * Creates a new Flyer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Flyer;
        $model->secret = Yii::$app->security->generateRandomString(4);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Flyer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModelOwn($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Copy an existing Flyer model to a new one.
     * If copy is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCopy($id)
    {
        $model = new Flyer;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model = $this->findModelOwn($id);
            $model->id = null;
            $model->name = $model->name.' (Kopie)';
            $model->secret = Yii::$app->security->generateRandomString(4);
            $model->isNewRecord = true;
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Flyer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModelOwn($id)->delete();
        return $this->redirect(['index']);
    }

    /**
     * Generates the qrcode for an existing Flyer model (to be used in an img url).
     * @param integer $secret
     * @return mixed
     */
    public function actionQrcode($secret)
    {
        return \dosamigos\qrcode\QrCode::png(Url::to(['flyer/show','secret'=>$secret],true));
    }

    /**
     * Prints an existing Flyer model
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

    use ContactTrait;
    /**
     * Displays contact page for contacting the owner of the Flyer model
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return mixed
     */
    public function actionContact($id)
    {
        return $this->contact($id,"Zettel");
    }

    /**
     * Finds the Flyer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Flyer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Flyer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    use FindModelOwnTrait;

    /**
     * Finds the Flyer model based on its secret
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Flyer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelBySecret($secret)
    {
        if (($model = Flyer::find()->where(['secret'=>$secret])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Der angeforderte Zettel existiert nicht.');
        }
    }
}
