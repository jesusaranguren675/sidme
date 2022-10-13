<?php

namespace app\controllers;
use Yii;
use app\models\Almacengeneral;
use app\models\AlmacengeneralSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AlmacengeneralController implements the CRUD actions for Almacengeneral model.
 */
class AlmacengeneralController extends Controller
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
     * Lists all Almacengeneral models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AlmacengeneralSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $almacen_general = 
        Yii::$app->db->createCommand("SELECT almacen_general.idal_gral, medicamentos.nombre,
        tipo_medicamento.descripcion,almacen_general.cantidad
        FROM almacen_general AS almacen_general JOIN
        medicamentos AS medicamentos
        ON medicamentos.idmedi=almacen_general.idmedi
        JOIN tipo_medicamento AS tipo_medicamento
        ON tipo_medicamento.idtipo=almacen_general.idtipo")->queryAll();

        return $this->render('index', [
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
            'almacen_general'       => $almacen_general,
        ]);
    }

    /**
     * Displays a single Almacengeneral model.
     * @param int $idal_gral Idal Gral
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idal_gral)
    {
        return $this->render('view', [
            'model' => $this->findModel($idal_gral),
        ]);
    }

    /**
     * Creates a new Almacengeneral model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Almacengeneral();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idal_gral' => $model->idal_gral]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Almacengeneral model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idal_gral Idal Gral
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idal_gral)
    {
        $model = $this->findModel($idal_gral);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idal_gral' => $model->idal_gral]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Almacengeneral model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idal_gral Idal Gral
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idal_gral)
    {
        $this->findModel($idal_gral)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Almacengeneral model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idal_gral Idal Gral
     * @return Almacengeneral the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idal_gral)
    {
        if (($model = Almacengeneral::findOne(['idal_gral' => $idal_gral])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
