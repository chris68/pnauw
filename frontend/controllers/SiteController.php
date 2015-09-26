<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use common\models\Auth;
use common\models\User;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\data\ActiveDataProvider;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\UserdataForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup', 'userdata'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                    // Signup actually should be possible all the time!
                    //    'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                    // Logout actually should be possible all the time!
                    //    'roles' => ['@'],
                    ],
                    [
                        'actions' => ['userdata','foreignlogin'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();
        Yii::info($attributes);

        /* @var $auth common\models\Auth */
        $auth = Auth::find()->where([
            'source' => $client->getId(),
            'source_id' => $attributes['id'],
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                $user = $auth->user;
                Yii::$app->user->login($user);
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                switch ($client->getId()) {
                    case 'google': $name = $attributes['displayName']; break;
                    case 'facebook': $name = $attributes['name']; break;
                }
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $client->getId(),
                    'source_id' => $attributes['id'],
                    'source_name' => $name,
                ]);
                $auth->save();
            } else {
                if ($auth->user->id <> Yii::$app->user->id) {
                    Yii::$app->getSession()->setFlash('error', 'Das angegebene Konto des externen Providers ist bereits mit einem anderen Account auf unserer Plattform verbunden. Logischerweise kann man jedoch immer nur genau ein Konto von uns mit genau einem Konto des externen Providers verbinden.');
                } else {
                    Yii::$app->getSession()->setFlash('error', 'Das angegebene Konto des externen Providers ist bereits mit diesem Account auf unserer Plattform verbunden. Zweimal geht nicht!');
                }
            }
        }
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', \Yii::t('base','Thank you for contacting us. We will respond to you as soon as possible.'));
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionTerms()
    {
        return $this->render('terms');
    }

    public function actionPrivacy()
    {
        return $this->render('privacy');
    }

    public function actionImpressum()
    {
        return $this->render('impressum');
    }

    public function actionHelp()
    {
        return $this->render('help');
    }

    public function actionReleasehistory()
    {
        return $this->render('releasehistory');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', \Yii::t('base','Check your email for further instructions.'));

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', \Yii::t('base','There was an error sending email.'));
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', \Yii::t('base','New password was saved.'));

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionUserdata()
    {
        $model = new UserdataForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->save();
                Yii::$app->getSession()->setFlash('success', 'Die Änderungen wurden übernommen');
                return $this->goHome();
            }
        }

        return $this->render('userdata', [
            'model' => $model,
        ]);
    }

    public function actionForeignlogin($delete='')
    {
        if ($delete=='ALL') {
            Auth::deleteAll("{{%auth}}.user_id = :owner", [':owner' => \Yii::$app->user->id]);
        }

        $query = Auth::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $dataProvider->setPagination(false);
        $dataProvider->query->andWhere("{{%auth}}.user_id = :owner", [':owner' => \Yii::$app->user->id]);

        Yii::$app->getUser()->setReturnUrl(['/site/foreignlogin']);
        return $this->render('foreignlogin', [
            'dataProvider' => $dataProvider,
        ]);
    }
}
