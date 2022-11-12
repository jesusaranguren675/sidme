<?php

namespace app\controllers;

use Yii;
use app\models\Medicamentos;
use app\models\MedicamentosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MedicamentosController implements the CRUD actions for Medicamentos model.
 */
class MedicamentosController extends Controller
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
     * Lists all Medicamentos models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MedicamentosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $medicamentos = 
        Yii::$app->db->createCommand("select
        detalle_medi.id_detalle_medi,
        medicamentos.nombre, 
        tipo_medicamento.descripcion
        from detalle_medi as detalle_medi
        join medicamentos as medicamentos
        on medicamentos.idmedi=detalle_medi.idmedi
        join tipo_medicamento as tipo_medicamento
        on detalle_medi.idtipo=tipo_medicamento.idtipo")->queryAll();

        return $this->render('index', [
            'searchModel'               => $searchModel,
            'dataProvider'              => $dataProvider,
            'medicamentos'              => $medicamentos,
        ]);
    }

    /**
     * Displays a single Medicamentos model.
     * @param int $idmedi Idmedi
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idmedi)
    {
        return $this->render('view', [
            'model' => $this->findModel($idmedi),
        ]);
    }

    /**
     * Creates a new Medicamentos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Medicamentos();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idmedi' => $model->idmedi]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Medicamentos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idmedi Idmedi
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($idmedi)
    {
        $model = $this->findModel($idmedi);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idmedi' => $model->idmedi]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Medicamentos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idmedi Idmedi
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idmedi)
    {
        $this->findModel($idmedi)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Medicamentos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idmedi Idmedi
     * @return Medicamentos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idmedi)
    {
        if (($model = Medicamentos::findOne(['idmedi' => $idmedi])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
