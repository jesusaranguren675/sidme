<?php

namespace app\controllers;

use Yii;
use app\models\Distribucion;
use app\models\DistribucionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;

/**
 * DistribucionController implements the CRUD actions for Distribucion model.
 */
class DistribucionController extends Controller
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
     * Lists all Distribucion models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new DistribucionSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $model = new Distribucion();

        $distribucion = 
        Yii::$app->db->createCommand("SELECT distribucion.iddis,
        distribucion.descripcion,
        medicamentos.nombre,
        tipo_medicamento.descripcion AS presentacion,
        detalle_dis.cantidad,
        detalle_dis.fecha
        FROM distribucion AS distribucion
        JOIN detalle_dis AS detalle_dis
        ON distribucion.iddis=detalle_dis.iddis
        JOIN detalle_medi AS detalle_medi
        ON detalle_medi.id_detalle_medi=detalle_dis.idmedi
        JOIN medicamentos AS medicamentos
        ON medicamentos.idmedi=detalle_medi.idmedi
        JOIN tipo_medicamento AS tipo_medicamento
        ON tipo_medicamento.idtipo=detalle_medi.idtipo")->queryAll();

        return $this->render('index', [
            'searchModel'                   => $searchModel,
            'dataProvider'                  => $dataProvider,
            'distribucion'                  => $distribucion,
            'model'                         => $model,
        ]);
    }

    public function actionReport() {

        $distribuciones = 
            Yii::$app->db->createCommand("SELECT distribucion.iddis,
            distribucion.descripcion,
            medicamentos.nombre,
            tipo_medicamento.descripcion AS presentacion,
            detalle_dis.cantidad,
            detalle_dis.fecha
            FROM distribucion AS distribucion
            JOIN detalle_dis AS detalle_dis
            ON distribucion.iddis=detalle_dis.iddis
            JOIN detalle_medi AS detalle_medi
            ON detalle_medi.id_detalle_medi=detalle_dis.idmedi
            JOIN medicamentos AS medicamentos
            ON medicamentos.idmedi=detalle_medi.idmedi
            JOIN tipo_medicamento AS tipo_medicamento
            ON tipo_medicamento.idtipo=detalle_medi.idtipo")->queryAll();
        
            $mpdf = new mPDF();
            //$mpdf->SetHeader(Html::img('@web/img/cintillo_pdf.jpg')); 
            $mpdf->setFooter('{PAGENO}'); 
            $mpdf->WriteHTML($this->renderPartial('_reportView', ['distribuciones' => $distribuciones]));
            $mpdf->Output();
            exit;
    }

    /**
     * Displays a single Distribucion model.
     * @param int $iddis Iddis
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($iddis)
    {
        return $this->render('view', [
            'model' => $this->findModel($iddis),
        ]);
    }

    /**
     * Creates a new Distribucion model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Distribucion();

        if (Yii::$app->request->isAjax) 
        {

            $idmedi         = $_POST['idmedi'];
            $descripcion    = $_POST['descripcion'];
            $destino         = $_POST['destino'];
            $cantidad       = $_POST['cantidad'];
            $idusu          = Yii::$app->user->identity->id;
            $fecha  = date('d/m/y');



            /* VALIDACIÓN CANTIDAD */
            $consulta_almacen = 
            Yii::$app->db->createCommand("SELECT almacen_general.cantidad 
            FROM almacen_general AS almacen_general
            WHERE idmedi=$idmedi")->queryAll();

            foreach ($consulta_almacen as $consulta_almacen)
            {
                $unidades = $consulta_almacen['cantidad'];
            }

            if($consulta_almacen)
            {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                if($unidades < $cantidad)
                {
                    return [
                        'data' => [
                            'success' => false,
                            'message' => 'No contamos con la cantidad solicitada',
                    ],
                        'code' => 0, // Some semantic codes that you know them for yourself
                    ];
                    return;
                }
            }
            /* FIN VALIDACIÓN CANTIDAD */

            /* REGISTRAR DISTRIBUCIÓN */
            $distribucion = Yii::$app->db->createCommand()->insert('distribucion', [
                'descripcion'                  => $descripcion,
                'idusu'                        => $idusu,
            ])->execute();

            $iddis = Yii::$app->db->getLastInsertID();

            $detalle_dis = 
            Yii::$app->db->createCommand("INSERT INTO public.detalle_dis(
                idmedi, iddis, destino, cantidad, fecha)
                VALUES ($idmedi, $iddis, $destino, $cantidad, '$fecha')")->queryAll();
            /* FIN REGISTRAR DISTRIBUCIÓN */

            $resta = $unidades - $cantidad;

            $update_almacen = 
            Yii::$app->db->createCommand("UPDATE public.almacen_general
            SET cantidad=$resta
            WHERE idal_gral=$idmedi")->queryAll();

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($detalle_dis && $distribucion)
            {
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Distribución Realizada Exitosamente',
                    ],
                    'code' => 1,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error al realizar la distribución',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    //Filtrar Unidades del Almacen
    //--------------------------------------------------------------------
    public function actionFiltrounidades()
    {

        if (Yii::$app->request->isAjax) 
        {
            $parametro = intval($_POST['unidad']);

            $unidades = Yii::$app->db->createCommand("SELECT almacen_general.idal_gral,
            almacen_general.cantidad, medicamentos.nombre, tipo_medicamento.descripcion
            FROM almacen_general JOIN detalle_medi AS detalle_medi
            ON almacen_general.idmedi=detalle_medi.id_detalle_medi
            JOIN medicamentos AS medicamentos
            ON medicamentos.idmedi=detalle_medi.idmedi
            JOIN tipo_medicamento AS tipo_medicamento
            ON tipo_medicamento.idtipo=detalle_medi.idtipo
            WHERE almacen_general.idal_gral=$parametro")->queryAll();

            if(empty($unidades))
            {
                $unidades = false;
            }

            foreach ($unidades as $unidades)
            {
                $unidades = $unidades['cantidad'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($_POST != "")
            {
                return [
                    'data' => [
                        'success'       => true,
                        'message'       => 'Consulta exitosa.',
                        'unidades'      =>  $unidades,
                    ],
                    'code' => 0,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error.',
                    ],
                'code' => 1, // Some semantic codes that you know them for yourself
                ];
            }

        }

    }
    //Fin Filtrar Unidades del Almacen
    //--------------------------------------------------------------------

    /**
     * Updates an existing Distribucion model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $iddis Iddis
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($iddis)
    {
        $model = $this->findModel($iddis);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'iddis' => $model->iddis]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Distribucion model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $iddis Iddis
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($iddis)
    {
        $this->findModel($iddis)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Distribucion model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $iddis Iddis
     * @return Distribucion the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($iddis)
    {
        if (($model = Distribucion::findOne(['iddis' => $iddis])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
