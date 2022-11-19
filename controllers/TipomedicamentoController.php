<?php

namespace app\controllers;

use app\models\Tipomedicamento;
use app\models\TipomedicamentoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TipomedicamentoController implements the CRUD actions for Tipomedicamento model.
 */
class TipomedicamentoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Tipomedicamento models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new TipomedicamentoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Tipomedicamento model.
     * @param int $idtipo Idtipo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idtipo)
    {
        return $this->render('view', [
            'model' => $this->findModel($idtipo),
        ]);
    }

    /**
     * Creates a new Tipomedicamento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Tipomedicamento();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idtipo' => $model->idtipo]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Tipomedicamento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idtipo Idtipo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idtipo)
    {
        $model = $this->findModel($idtipo);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idtipo' => $model->idtipo]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Tipomedicamento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idtipo Idtipo
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idtipo)
    {
        $this->findModel($idtipo)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tipomedicamento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idtipo Idtipo
     * @return Tipomedicamento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idtipo)
    {
        if (($model = Tipomedicamento::findOne(['idtipo' => $idtipo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
