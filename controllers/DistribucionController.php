<?php

namespace app\controllers;

use Yii;
use app\models\Distribucion;
use app\models\DistribucionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use conquer\select2\Select2Action;
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
        detalle_dis.correlativo,
        distribucion.descripcion,
        medicamentos.nombre,
        tipo_medicamento.descripcion AS presentacion,
        sede.nombre AS destino,
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
        ON tipo_medicamento.idtipo=detalle_medi.idtipo
        JOIN sede AS sede
        ON sede.idsede=detalle_dis.destino")->queryAll();

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

    public function actionNotaentrega($id) {

        $distribucion = 
            Yii::$app->db->createCommand("SELECT distribucion.iddis,
            detalle_dis.correlativo,
            distribucion.descripcion,
            medicamentos.nombre,
            tipo_medicamento.descripcion AS presentacion,
            sede.nombre AS destino,
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
            ON tipo_medicamento.idtipo=detalle_medi.idtipo
            JOIN sede AS sede
            ON sede.idsede=detalle_dis.destino
            WHERE distribucion.iddis=$id")->queryAll();

            foreach ($distribucion as $distribucion_p) {
                $correlativo = $distribucion_p['correlativo'];
            }

            $mpdf = new mPDF();
            //$mpdf->SetHeader(Html::img('@web/img/cintillo_pdf.jpg')); 
            $mpdf->setFooter('{PAGENO}'); 
            $mpdf->WriteHTML($this->renderPartial('_notaEntrega', ['distribucion' => $distribucion, 'correlativo' => $correlativo]));
            $mpdf->Output();
            exit;
    }

    /**
     * Displays a single Distribucion model.
     * @param int $iddis Iddis
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $data_iddis = $_POST['data_iddis'];

        $distribucion = 
        Yii::$app->db->createCommand("SELECT distribucion.iddis,
        detalle_dis.correlativo,
        distribucion.descripcion,
        medicamentos.nombre,
        tipo_medicamento.descripcion AS presentacion,
        sede.nombre AS destino,
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
        ON tipo_medicamento.idtipo=detalle_medi.idtipo
        JOIN sede AS sede
        ON sede.idsede=detalle_dis.destino
        WHERE distribucion.iddis=$data_iddis")->queryAll();

        foreach ($distribucion as $distribucion_p) {
            $iddis              = $distribucion_p['iddis'];
            $correlativo        = $distribucion_p['correlativo'];
            $descripcion        = $distribucion_p['descripcion'];
            $nombre             = $distribucion_p['nombre'];
            $presentacion       = $distribucion_p['presentacion'];
            $destino            = $distribucion_p['destino'];
            $cantidad           = $distribucion_p['cantidad'];
            $fecha              = $distribucion_p['fecha'];
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if($distribucion)
        {
            return [
                'data' => [
                    'success'           => true,
                    'message'           => 'Distribución Realizada Exitosamente',
                    'iddis'             => $iddis,
                    'correlativo'       => $correlativo,
                    'descripcion'       => $descripcion,
                    'nombre'            => $nombre,
                    'presentacion'      => $presentacion,
                    'destino'           => $destino,
                    'cantidad'          => $cantidad,
                    'fecha'             => $fecha,
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
            $descripcion    = strtolower($_POST['descripcion']);
            $destino        = $_POST['destino'];
            $cantidad       = $_POST['cantidad'];
            $idusu          = Yii::$app->user->identity->id;
            $fecha          = date('d/m/y');
            $dia            = date('d');
            $mes            = date('m');
            $anio           = date('y');



            /* VALIDACIÓN CANTIDAD */
            $consulta_almacen = 
            Yii::$app->db->createCommand("SELECT *
            FROM almacen_general AS almacen_general
            WHERE idmedi=$idmedi")->queryAll();

            foreach ($consulta_almacen as $consulta_almacen)
            {
                $unidades = $consulta_almacen['cantidad'];
                $idal_gral = $consulta_almacen['idal_gral'];
            }

            // var_dump($consulta_almacen); die();

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

            $correlativo = "$iddis"."-"."$dia$mes$anio";

            $detalle_dis = 
            Yii::$app->db->createCommand("INSERT INTO public.detalle_dis(
                idmedi, iddis, destino, cantidad, fecha, correlativo)
                VALUES ($idmedi, $iddis, $destino, $cantidad, '$fecha', '$correlativo')")->queryAll();
            /* FIN REGISTRAR DISTRIBUCIÓN */

            $resta = $unidades - $cantidad;

            $update_almacen = 
            Yii::$app->db->createCommand("UPDATE public.almacen_general
            SET cantidad=$resta
            WHERE idal_gral=$idal_gral")->queryAll();

            $distribucion = 
            Yii::$app->db->createCommand("SELECT distribucion.iddis,
            detalle_dis.correlativo,
            distribucion.descripcion,
            medicamentos.nombre,
            tipo_medicamento.descripcion AS presentacion,
            sede.nombre AS destino,
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
            ON tipo_medicamento.idtipo=detalle_medi.idtipo
            JOIN sede AS sede
            ON sede.idsede=detalle_dis.destino
            WHERE distribucion.iddis=$iddis")->queryAll();

            foreach ($distribucion as $distribucion_p) {
                $correlativo = $distribucion_p['correlativo'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($detalle_dis && $distribucion)
            {
                return [
                    'data' => [
                        'success'       => true,
                        'message'       => 'Distribución Realizada Exitosamente',
                        'correlativo'   => $correlativo,
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

    public function actionQueryupdate()
    {

        $data_iddis = $_POST['data_iddis'];

        if (Yii::$app->request->isAjax) 
        {
           
            $distribucion = 
            Yii::$app->db->createCommand("SELECT distribucion.iddis,
            detalle_dis.correlativo,
            distribucion.descripcion,
            medicamentos.nombre,
            tipo_medicamento.descripcion AS presentacion,
            sede.nombre AS destino,
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
            ON tipo_medicamento.idtipo=detalle_medi.idtipo
            JOIN sede AS sede
            ON sede.idsede=detalle_dis.destino
            WHERE distribucion.iddis=$data_iddis")->queryAll();

            foreach ($distribucion as $distribucion_p) {
                $iddis              = $distribucion_p['iddis'];
                $correlativo        = $distribucion_p['correlativo'];
                $descripcion        = $distribucion_p['descripcion'];
                $nombre             = $distribucion_p['nombre'];
                $presentacion       = $distribucion_p['presentacion'];
                $destino            = $distribucion_p['destino'];
                $cantidad           = $distribucion_p['cantidad'];
                $fecha              = $distribucion_p['fecha'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($distribucion)
            {
                return [
                    'data' => [
                        'success'           => true,
                        'message'           => 'Distribución Realizada Exitosamente',
                        'iddis'             => $iddis,
                        'correlativo'       => $correlativo,
                        'descripcion'       => $descripcion,
                        'nombre'            => $nombre,
                        'presentacion'      => $presentacion,
                        'destino'           => $destino,
                        'cantidad'          => $cantidad,
                        'fecha'             => $fecha,
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

    }

    public function actionResponderpedido()
    {
        $model = new Distribucion();
        
        if (Yii::$app->request->isAjax) 
        {

            $idmedi         = $_POST['idmedi'];
            $idpedi         = $_POST['idpedi'];
            $descripcion    = strtolower($_POST['descripcion']);
            $destino        = $_POST['destino'];
            $cantidad       = $_POST['cantidad'];
            $idusu          = Yii::$app->user->identity->id;
            $fecha          = date('d/m/y');
            $dia            = date('d');
            $mes            = date('m');
            $anio           = date('y');



            /* VALIDACIÓN CANTIDAD */
            $consulta_almacen = 
            Yii::$app->db->createCommand("SELECT almacen_general.cantidad , almacen_general.idal_gral
            FROM almacen_general AS almacen_general
            WHERE idmedi=$idmedi")->queryAll();

            foreach ($consulta_almacen as $consulta_almacen)
            {
                $unidades = $consulta_almacen['cantidad'];
                $idal_gral = $consulta_almacen['idal_gral'];
            }

            // var_dump($unidades); die();

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
                        'code' => 0,
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

            $correlativo = "$iddis"."-"."$dia$mes$anio";

            $detalle_dis = 
            Yii::$app->db->createCommand("INSERT INTO public.detalle_dis(
                idmedi, iddis, destino, cantidad, fecha, correlativo)
                VALUES ($idmedi, $iddis, $destino, $cantidad, '$fecha', '$correlativo')")->queryAll();
            /* FIN REGISTRAR DISTRIBUCIÓN */

            $resta = $unidades - $cantidad;

            $update_almacen = 
            Yii::$app->db->createCommand("UPDATE public.almacen_general
            SET cantidad=$resta
            WHERE idal_gral=$idal_gral")->queryAll();

            $update_pedido = 
            Yii::$app->db->createCommand("UPDATE public.detalle_pedi
            SET estatus=4
            WHERE idpedi=$idpedi")->queryAll();

            $pedidos = 
            Yii::$app->db->createCommand("SELECT pedidos.idpedi,
            detalle_pedi.correlativo, 
            pedidos.descripcion,
            medicamentos.nombre,
            tipo_medicamento.descripcion AS presentacion,
            detalle_pedi.cantidad, detalle_pedi.estatus,
            detalle_pedi.fecha
            FROM pedidos AS pedidos
            JOIN detalle_pedi AS detalle_pedi
            ON detalle_pedi.idpedi=pedidos.idpedi
            JOIN detalle_medi AS detalle_medi
            ON detalle_medi.id_detalle_medi=detalle_pedi.idmedi
            JOIN medicamentos AS medicamentos
            ON medicamentos.idmedi=detalle_medi.idmedi
            JOIN tipo_medicamento AS tipo_medicamento
            ON tipo_medicamento.idtipo=detalle_medi.idtipo
            WHERE pedidos.idpedi=$idpedi")->queryAll();

            foreach ($pedidos as $pedidos) {
                $idpedi         = $pedidos['idpedi'];
                $correlativo    = $pedidos['correlativo'];
                $descripcion    = $pedidos['descripcion'];
                $nombre         = $pedidos['nombre'];
                $presentacion   = $pedidos['presentacion'];
                $cantidad       = $pedidos['cantidad'];
                $estatus        = $pedidos['estatus'];
                $fecha          = $pedidos['fecha'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($detalle_dis && $distribucion)
            {
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Pedido Respondido Exitosamente',
                        'idpedi'            => $idpedi,
                        'correlativo'       => $correlativo,
                        'descripcion'       => $descripcion,
                        'nombre'            => $nombre, 
                        'presentacion'      => $presentacion,
                        'cantidad'          => $cantidad,
                        'estatus'           => $estatus,
                        'fecha'             => $fecha,  
                    ],
                    'code' => 1,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error al responder el pedido',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
        }
    
        return $this->render('_form_responder_pedidos', [
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
    public function actionUpdate()
    {
        if (Yii::$app->request->isAjax) 
        {
            $iddis          = $_POST['iddis_update'];
            $idmedi         = $_POST['distribucion_idmedi_update'];
            $descripcion    = strtolower($_POST['distribucion_descripcion_update']);
            $destino        = $_POST['distribucion_sede_update'];
            $cantidad       = $_POST['distribucion_cantidad_update'];

            /* ACTUALIZAR DISTRIBUCION */
            $update_dis = Yii::$app->db->createCommand("UPDATE public.distribucion
            SET descripcion='$descripcion'
            WHERE iddis=$iddis")->queryAll();

            $update_detalle_dis= Yii::$app->db->createCommand("UPDATE public.detalle_dis
            SET idmedi=$idmedi, destino=$destino, cantidad=$cantidad
            WHERE iddis=$iddis")->queryAll();
            /* FIN ACTUALIZAR DISTRIBUCION */

            $distribucion = 
            Yii::$app->db->createCommand("SELECT distribucion.iddis,
            detalle_dis.correlativo,
            distribucion.descripcion,
            medicamentos.nombre,
            tipo_medicamento.descripcion AS presentacion,
            sede.nombre AS destino,
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
            ON tipo_medicamento.idtipo=detalle_medi.idtipo
            JOIN sede AS sede
            ON sede.idsede=detalle_dis.destino
            WHERE distribucion.iddis=$iddis")->queryAll();

            foreach ($distribucion as $distribucion_p) {
                $iddis              = $distribucion_p['iddis'];
                $correlativo        = $distribucion_p['correlativo'];
                $descripcion        = $distribucion_p['descripcion'];
                $nombre             = $distribucion_p['nombre'];
                $presentacion       = $distribucion_p['presentacion'];
                $destino            = $distribucion_p['destino'];
                $cantidad           = $distribucion_p['cantidad'];
                $fecha              = $distribucion_p['fecha'];
            }


            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($update_dis && $update_detalle_dis)
            {
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Distribucion Modificada Exitosamente',
                        'iddis'             => $iddis,
                        'correlativo'       => $correlativo,
                        'descripcion'       => $descripcion,
                        'nombre'            => $nombre,
                        'presentacion'      => $presentacion,
                        'destino'           => $destino,
                        'cantidad'          => $cantidad,
                        'fecha'             => $fecha,
                    ],
                    'code' => 1,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error al modificar la distribucion',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
        }
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
