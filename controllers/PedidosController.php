<?php

namespace app\controllers;

use Yii;
use app\models\Pedidos;
use app\models\PedidosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
//use kartik\mpdf\Pdf;
use yii\helpers\Html;
use Mpdf\Mpdf;

/**
 * PedidosController implements the CRUD actions for Pedidos model.
 */
class PedidosController extends Controller
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
     * Lists all Pedidos models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new PedidosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $model = new Pedidos();

        $pedidos = 
        Yii::$app->db->createCommand("SELECT pedidos.idpedi, 
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
        ")->queryAll();

        return $this->render('index', [
            'searchModel'               => $searchModel,
            'dataProvider'              => $dataProvider,
            'pedidos'                   => $pedidos,
            'model'                     => $model,
        ]);
    }


public function actionReport() {

    $pedidos = 
        Yii::$app->db->createCommand("SELECT pedidos.idpedi, 
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
        ")->queryAll();
    
        $mpdf = new mPDF();
        $mpdf->SetHeader(Html::img('@web/img/cintillo_pdf.jpg', ['style' => 'margin-bottom:50px;'])); 
        $mpdf->setFooter('{PAGENO}'); 
        $mpdf->WriteHTML($this->renderPartial('_reportView', ['pedidos' => $pedidos]));
        $mpdf->Output();
        exit;
}

    /**
     * Displays a single Pedidos model.
     * @param int $idpedi Idpedi
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {

        $idpedi = $_POST['data_idpedi'];

        if (Yii::$app->request->isAjax) 
        {
           
            $pedidos = 
            Yii::$app->db->createCommand("SELECT pedidos.idpedi, 
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
                $descripcion    = $pedidos['descripcion'];
                $nombre         = $pedidos['nombre'];
                $presentacion   = $pedidos['presentacion'];
                $cantidad       = $pedidos['cantidad'];
                $estatus        = $pedidos['estatus'];
                $fecha          = $pedidos['fecha'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($pedidos)
            {
                return [
                    'data' => [
                        'success'           => true,
                        'message'           => 'Consulta Exitosa',
                        'idpedi'            => $idpedi,
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
                        'message' => 'Ocurrió un error en la consulta',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
        }

    }

    /**
     * Creates a new Pedidos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Pedidos();

        if (Yii::$app->request->isAjax) 
        {
            $descripcion            = $_POST['descripcion'];
            $idmedi                 = $_POST['idmedi'];
            $procedencia            = $_POST['procedencia'];
            $cantidad               = $_POST['cantidad'];
            $estatus                = $_POST['estatus'];
            $idusu                  = Yii::$app->user->identity->id;
            $fecha                  = date('d/m/y');

            /* REGISTRAR PEDIDO */
            $pedido = Yii::$app->db->createCommand()->insert('pedidos', [
                'descripcion'                  => $descripcion,
                'idusu'                        => $idusu,
            ])->execute();

            $idpedi = Yii::$app->db->getLastInsertID();

            $detalle_pedi = 
            Yii::$app->db->createCommand("INSERT INTO public.detalle_pedi(
                idpedi, idmedi, procedencia, cantidad, fecha, estatus)
                VALUES ($idpedi, $idmedi, $procedencia, $cantidad, '$fecha', $estatus);")->queryAll();
            /* FIN REGISTRAR DISTRIBUCIÓN */


            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($pedido && $detalle_pedi)
            {
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Pedido Registrado Exitosamente',
                    ],
                    'code' => 1,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error al registrar el pedido',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Pedidos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idpedi Idpedi
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        //var_dump($_POST); die();

        if (Yii::$app->request->isAjax) 
        {
            $idpedi                 = $_POST['idpedi_update'];
            $descripcion            = $_POST['pedido_descripcion_update'];
            $idmedi                 = $_POST['pedido_idmedi_update'];
            $procedencia            = $_POST['pedido_sede_update'];
            $cantidad               = $_POST['pedido_cantidad_update'];
            $estatus                = $_POST['pedido_estatus_update'];
            $idusu                  = Yii::$app->user->identity->id;

            /* ACTUALIZAR PEDIDO */
            $update_pedido = Yii::$app->db->createCommand("UPDATE public.pedidos
            SET descripcion='$descripcion'
            WHERE idpedi=$idpedi")->queryAll();

            $update_detalle_pedido = Yii::$app->db->createCommand("UPDATE public.detalle_pedi
            SET idmedi=$idmedi, procedencia=$procedencia, cantidad=$cantidad, estatus=$estatus
            WHERE idpedi=$idpedi")->queryAll();
            /* FIN ACTUALIZAR PEDIDO */


            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($update_pedido && $update_detalle_pedido)
            {
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Pedido Modificado Exitosamente',
                    ],
                    'code' => 1,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error al modificar el pedido',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
        }

    }

    /**
     * Deletes an existing Pedidos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idpedi Idpedi
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idpedi)
    {
        $this->findModel($idpedi)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Pedidos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idpedi Idpedi
     * @return Pedidos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idpedi)
    {
        if (($model = Pedidos::findOne(['idpedi' => $idpedi])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
