<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

     /*
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
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
    */

    /**
     * {@inheritdoc}
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
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionButtons()
    {
        return $this->render('buttons');
    }
    
    public function actionDashboard()
    {
        return $this->render('dashboard');
    }

    public function actionCards()
    {
        return $this->render('cards');
    }

    public function actionUtilitiescolor()
    {
        return $this->render('utilitiescolor');
    }

    public function actionUtilitiesborder()
    {
        return $this->render('utilitiesborder');
    }


    public function actionUtilitiesanimation()
    {
        return $this->render('utilitiesanimation');
    }


    public function actionUtilitiesother()
    {
        return $this->render('utilitiesother');
    }

    /*
    public function actionLogin()
    {
        return $this->render('login');
    }
    */
    

    public function actionTables()
    {
        return $this->render('tables');
    }


    /**
     * Login action.
     *
     * @return Response|string
     */

    
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            return $this->redirect(['dashboard']);
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }
    
    
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
