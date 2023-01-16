<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\BackendUser;
use app\models\BackendUser as ModelsBackendUser;
use kartik\mpdf\Pdf;

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

    public function actionReport($message) {
       
        //$message = "Hola Mundo";

        return $this->render('_reportView', [
            'message'   => $message
        ]);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new \app\models\LoginForm();

        return $this->render('login', ['model' => $model]);
        //return $this->render('index');
        //return $this->redirect(['login']);
    }

    public function actionButtons()
    {
        return $this->render('buttons');
    }
    
    public function actionDashboard()
    {


        $usuarios = 
        Yii::$app->db->createCommand("select count('id') from public.user;")->queryAll();

        foreach ($usuarios as $usuarios) {
            $usuarios = $usuarios['count'];
        }

        $recepciones = 
        Yii::$app->db->createCommand("select count('idett') from entradas_medicamentos;")->queryAll();

        foreach ($recepciones as $recepciones) {
            $recepciones = $recepciones['count'];
        }

        $distribuciones = 
        Yii::$app->db->createCommand("select count('idtt') from distribucion;")->queryAll();

        foreach ($distribuciones as $distribuciones) {
            $distribuciones = $distribuciones['count'];
        }

        $pedidos = 
        Yii::$app->db->createCommand("select count('idpedi') from pedidos;")->queryAll();

        foreach ($pedidos as $pedidos) {
            $pedidos = $pedidos['count'];
        }

        return $this->render('dashboard', [
            'usuarios'          => $usuarios,
            'recepciones'       => $recepciones,
            'distribuciones'    => $distribuciones,
            'pedidos'           => $pedidos,
        ]);
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

        //return $this->goHome();
        return $this->redirect(['login']);
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
