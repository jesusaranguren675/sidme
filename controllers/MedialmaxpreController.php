<?php


namespace app\controllers;

use Yii;

use app\models\Medialmaxpre;
use app\models\MedialmaxpreSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MedialmaxpreController implements the CRUD actions for Medialmaxpre model.
 */
class MedialmaxpreController extends Controller
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
     * Lists all Medialmaxpre models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MedialmaxpreSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $almacen = 
        Yii::$app->db->createCommand("
        SELECT almacen.id_medi_alma_x_pre, ma.nombre_medicamento_almacen, PRE.nombre_presentacion, 
        MS.cantidad AS entrada ,ME.cantidad AS salida ,stock AS existencia
        FROM public.medi_alma_x_pre AS almacen
        JOIN medicamentos_almacen AS MA
        ON MA.id_medicamento_almacen=almacen.id_medicamento_almacen
        JOIN presentaciones AS PRE
        ON PRE.id_presentacion=almacen.id_presentacion
        JOIN entradas_medicamentos AS ME
        ON ME.id_presentacion=almacen.id_presentacion
        JOIN salidas_medicamentos AS MS
        ON MS.id_presentacion=almacen.id_presentacion")->queryAll();



        return $this->render('index', [
            'searchModel'       => $searchModel,
            'almacen'           => $almacen,
            'dataProvider'      => $dataProvider,
        ]);
    }

    /**
     * Displays a single Medialmaxpre model.
     * @param int $id_medi_alma_x_pre Id Medi Alma X Pre
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_medi_alma_x_pre)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_medi_alma_x_pre),
        ]);
    }

    /**
     * Creates a new Medialmaxpre model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Medialmaxpre();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_medi_alma_x_pre' => $model->id_medi_alma_x_pre]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Medialmaxpre model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_medi_alma_x_pre Id Medi Alma X Pre
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_medi_alma_x_pre)
    {
        $model = $this->findModel($id_medi_alma_x_pre);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_medi_alma_x_pre' => $model->id_medi_alma_x_pre]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Medialmaxpre model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_medi_alma_x_pre Id Medi Alma X Pre
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_medi_alma_x_pre)
    {
        $this->findModel($id_medi_alma_x_pre)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Medialmaxpre model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_medi_alma_x_pre Id Medi Alma X Pre
     * @return Medialmaxpre the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_medi_alma_x_pre)
    {
        if (($model = Medialmaxpre::findOne(['id_medi_alma_x_pre' => $id_medi_alma_x_pre])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
