<?php

namespace app\controllers;
use yii;
use app\models\Sede;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class SedeController extends \yii\web\Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
