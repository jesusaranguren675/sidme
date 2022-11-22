<?php

namespace app\controllers;

use app\models\Asignacionroles;
use app\models\AsignacionrolesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AsignacionrolesController implements the CRUD actions for Asignacionroles model.
 */
class AsignacionrolesController extends Controller
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
     * Lists all Asignacionroles models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AsignacionrolesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Asignacionroles model.
     * @param int $id_asig_rol Id Asig Rol
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_asig_rol)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_asig_rol),
        ]);
    }

    /**
     * Creates a new Asignacionroles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Asignacionroles();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_asig_rol' => $model->id_asig_rol]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Asignacionroles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_asig_rol Id Asig Rol
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_asig_rol)
    {
        $model = $this->findModel($id_asig_rol);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_asig_rol' => $model->id_asig_rol]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Asignacionroles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_asig_rol Id Asig Rol
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_asig_rol)
    {
        $this->findModel($id_asig_rol)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Asignacionroles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_asig_rol Id Asig Rol
     * @return Asignacionroles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_asig_rol)
    {
        if (($model = Asignacionroles::findOne(['id_asig_rol' => $id_asig_rol])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
