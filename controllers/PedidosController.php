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
        sede.nombre AS procedencia,
        detalle_pedi.cantidad, detalle_pedi.estatus,
        detalle_pedi.fecha, detalle_pedi.correlativo as id_orden
        FROM pedidos AS pedidos
        JOIN detalle_pedi AS detalle_pedi
        ON detalle_pedi.idpedi=pedidos.idpedi
        JOIN detalle_medi AS detalle_medi
        ON detalle_medi.id_detalle_medi=detalle_pedi.idmedi
        JOIN medicamentos AS medicamentos
        ON medicamentos.idmedi=detalle_medi.idmedi
        JOIN tipo_medicamento AS tipo_medicamento
        ON tipo_medicamento.idtipo=detalle_medi.idtipo
        JOIN sede AS sede
        ON sede.idsede=detalle_pedi.procedencia
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
            sede.nombre AS procedencia,
            detalle_pedi.cantidad, detalle_pedi.estatus,
            detalle_pedi.fecha, detalle_pedi.correlativo as correlativo,
            detalle_pedi.estatus as estatus
            FROM pedidos AS pedidos
            JOIN detalle_pedi AS detalle_pedi
            ON detalle_pedi.idpedi=pedidos.idpedi
            JOIN detalle_medi AS detalle_medi
            ON detalle_medi.id_detalle_medi=detalle_pedi.idmedi
            JOIN medicamentos AS medicamentos
            ON medicamentos.idmedi=detalle_medi.idmedi
            JOIN tipo_medicamento AS tipo_medicamento
            ON tipo_medicamento.idtipo=detalle_medi.idtipo
            JOIN sede AS sede
            ON sede.idsede=detalle_pedi.procedencia")->queryAll();
        
            $mpdf = new mPDF();
            //$mpdf->SetHeader(Html::img('@web/img/cintillo_pdf.jpg')); 
            $mpdf->setFooter('{PAGENO}'); 
            $mpdf->WriteHTML($this->renderPartial('_reportView', ['pedidos' => $pedidos]));
            $mpdf->Output();
            exit;
    }

    public function actionNotaentrega($id) {

        $pedidos = 
            Yii::$app->db->createCommand("SELECT pedidos.idpedi,
			detalle_pedi.correlativo AS orden,
            pedidos.descripcion,
            medicamentos.nombre,
            tipo_medicamento.descripcion AS presentacion,
			sede.nombre AS procedencia,
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
			JOIN sede AS sede
        	ON sede.idsede=detalle_pedi.procedencia
			WHERE pedidos.idpedi=$id
            ")->queryAll();

            $medicamentos = 
            Yii::$app->db->createCommand("SELECT mp.id_mpedi, medicamentos.nombre, tipo_medicamento.descripcion as presentacion,
            mp.cantidad, 
            pedidos.descripcion, detalle_pedi.procedencia, pedidos.idusu
            from medicamentos_pedidos as mp
            join pedidos as pedidos on pedidos.idpedi=mp.idpedi
            join detalle_pedi as detalle_pedi on detalle_pedi.idpedi=mp.idpedi
            join detalle_medi as detalle_medi
            on detalle_medi.id_detalle_medi=mp.idmedi
            join medicamentos as medicamentos
            on medicamentos.idmedi=detalle_medi.idmedi
            join tipo_medicamento as tipo_medicamento
            on tipo_medicamento.idtipo=detalle_medi.idtipo
            where pedidos.idpedi=$id")->queryAll();

            foreach ($pedidos as $pedidos_p) {
                $orden = $pedidos_p['orden'];
            }

            $mpdf = new mPDF();
            //$mpdf->SetHeader(Html::img('@web/img/cintillo_pdf.jpg')); 
            $mpdf->setFooter('{PAGENO}'); 
            $mpdf->WriteHTML($this->renderPartial('_notaEntrega', ['pedidos' => $pedidos, 'orden' => $orden, 'medicamentos' => $medicamentos]));
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
            detalle_pedi.fecha, detalle_pedi.correlativo as id_orden
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
                $id_orden       = $pedidos['id_orden'];
            }

            $medicamentos = 
            Yii::$app->db->createCommand("SELECT mp.id_mpedi, medicamentos.nombre, tipo_medicamento.descripcion as presentacion,
            mp.cantidad, 
            pedidos.descripcion, detalle_pedi.procedencia, pedidos.idusu
            from medicamentos_pedidos as mp
            join pedidos as pedidos on pedidos.idpedi=mp.idpedi
            join detalle_pedi as detalle_pedi on detalle_pedi.idpedi=mp.idpedi
            join detalle_medi as detalle_medi
            on detalle_medi.id_detalle_medi=mp.idmedi
            join medicamentos as medicamentos
            on medicamentos.idmedi=detalle_medi.idmedi
            join tipo_medicamento as tipo_medicamento
            on tipo_medicamento.idtipo=detalle_medi.idtipo
            where pedidos.idpedi=$idpedi")->queryAll();

           //$mensaje = "Hola Mundo";
            //$tabla_medicamentos = "<p><p>";

           

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($pedidos)
            {
                return [
                    'data' => [
                        'success'            => true,
                        'message'            => 'Consulta Exitosa',
                        'idpedi'             => $idpedi,
                        'descripcion'        => $descripcion,
                        'nombre'             => $nombre, 
                        'presentacion'       => $presentacion,
                        'cantidad'           => $cantidad,
                        'estatus'            => $estatus,
                        'fecha'              => $fecha,  
                        'id_orden'           => $id_orden,
                        'medicamentos'      => $medicamentos,
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
                    'code' => 0, 
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

            //var_dump($_POST); die();

            $descripcion            = strtolower($_POST['descripcion']);
            $idmedi                 = $_POST['idmedi'];
            $procedencia            = $_POST['procedencia'];
            $cantidad               = $_POST['cantidad'];
            $estatus                = 2;
            $idusu                  = Yii::$app->user->identity->id;
            $fecha                  = date('d/m/y');
            $dia                    = date('d');
            $mes                    = date('m');
            $anio                   = date('y');

            /* REGISTRAR PEDIDO */
            $pedido = Yii::$app->db->createCommand()->insert('pedidos', [
                'descripcion'                  => $descripcion,
                'idusu'                        => $idusu,
            ])->execute();

            $idpedi = Yii::$app->db->getLastInsertID();

            $correlativo = "$idpedi"."-"."$dia$mes$anio";

            $detalle_pedi = 
            Yii::$app->db->createCommand("INSERT INTO public.detalle_pedi(
                idpedi, idmedi, procedencia, cantidad, fecha, estatus, correlativo)
                VALUES ($idpedi, $idmedi, $procedencia, $cantidad, '$fecha', $estatus, '$correlativo');")->queryAll();

            $idpedi = Yii::$app->db->getLastInsertID();
            /* FIN REGISTRAR PEDIDO */

            /* REGISTRAR MULTIPLES MEDICAMENTOS */

            $temporal_multiples_medicamentos = 
            Yii::$app->db->createCommand("SELECT * FROM temporal_medicamentos_pedidos")->queryAll();

            foreach ($temporal_multiples_medicamentos as $temporal_multiples_medicamentos) {
                $idmedi_mltp         = $temporal_multiples_medicamentos['idmedi'];
                $cantidad_mltp       = $temporal_multiples_medicamentos['cantidad'];

                $insert_multiples_medicamentos = 
                Yii::$app->db->createCommand("INSERT INTO public.medicamentos_pedidos(
                idpedi, idmedi, cantidad)
                VALUES ($idpedi, $idmedi_mltp, $cantidad_mltp);")->queryAll();

            }

            /* FIN REGISTRAR MULTIPLES MEDICAMENTOS /*

            /* CONSULTAR PEDIDO REGISTRADO ANTERIORMENTE */
            $pedidos = 
            Yii::$app->db->createCommand("SELECT pedidos.idpedi, 
            pedidos.descripcion,
            medicamentos.nombre,
            tipo_medicamento.descripcion AS presentacion,
            detalle_pedi.cantidad, detalle_pedi.estatus,
            detalle_pedi.fecha, detalle_pedi.correlativo as id_orden
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
                $id_orden       = $pedidos['id_orden'];
            }
            /* FIN CONSULTAR PEDIDO REGISTRADO ANTERIORMENTE */

            // //Enviar correo a los integrantes
            // //-----------------------------------

                /*
                 Yii::$app->mailer->compose()
                 ->setFrom('jesusaranguren675@gmail.com')
                 ->setTo('jesusaranguren675@gmail.com')
                 ->setSubject('Se ha registrado un pedido con el N° '.$id_orden.'')
                 ->setTextBody('')
                 //->setHtmlBody('<b>La Universidad Politécnica Territorial de Caracas "Mariscal Sucre" informa que su proyecto ha sido registrado exitosamente bajo el número '.$id_proyecto.', y se encuentra a la espera de aprobación."</b></br>http://localhost:8080/sigepsi/web/index.php')
                 ->setHtmlBody('
                             <strong>Descripción:</strong> '.$descripcion.''.'<br>'.
                                 '<strong>Medicamento:</strong> '.$nombre.' '.$presentacion.'<br>'.
                                 '<strong>Fecha:</strong> '.$fecha.'<br>'.
                                 '<strong>A la espera de aprobación</strong>'
                 )
                 ->send();

                 */
             //Fin enviar correo a los integrantes
             //-----------------------------------


            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            // return $this->redirect(Yii::$app->request->baseUrl."/index.php?r=pedidos/index");
            if($pedido && $detalle_pedi)
            {

                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Pedido Registrado Exitosamente',
                        'idpedi'            => $idpedi,
                        'descripcion'       => $descripcion,
                        'nombre'            => $nombre, 
                        'presentacion'      => $presentacion,
                        'cantidad'          => $cantidad,
                        'estatus'           => $estatus,
                        'fecha'             => $fecha,
                        'id_orden'          => $id_orden,  
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

    public function actionFiltromedicamentos()
    {
        $pedido_idmedi      = $_POST['pedido_idmedi'];
        $pedido_cantidad    = $_POST['pedido_cantidad'];

        if (Yii::$app->request->isAjax) 
        {
           
            $medicamento = 
            Yii::$app->db->createCommand("SELECT
            detalle_medi.id_detalle_medi,
            medicamentos.nombre, tipo_medicamento.idtipo,
            tipo_medicamento.descripcion as presentacion
            FROM detalle_medi AS detalle_medi
            JOIN medicamentos AS medicamentos
            ON medicamentos.idmedi=detalle_medi.idmedi
            JOIN tipo_medicamento AS tipo_medicamento
            ON detalle_medi.idtipo=tipo_medicamento.idtipo
            WHERE detalle_medi.id_detalle_medi=$pedido_idmedi")->queryAll();

            foreach ($medicamento as $medicina) {
                $id_detalle_medi      = $medicina['id_detalle_medi'];
                $nombre               = $medicina['nombre'];
                $presentacion         = $medicina['presentacion'];
                $idtipo               = $medicina['idtipo'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($medicamento)
            {
                //validacion
                $consulta_medicamento = 
                Yii::$app->db->createCommand("SELECT * FROM 
                temporal_medicamentos_pedidos WHERE idmedi=$id_detalle_medi")->queryAll();

                foreach ($consulta_medicamento as $consulta_medicamento) {
                    $unidades = $consulta_medicamento['idmedi'];
                    $idal_gral = $consulta_medicamento['cantidad'];
                }
                //Fin validación

                if($consulta_medicamento)
                {
                    return [
                        'data' => [
                            'success' => false,
                            'message' => 'El Medicamento Ya Existe',
                            'info'    => 'El Medicamento que intentas agregar ya existe en la lista.'
                    ],
                        'code' => 0,
                    ];
                }
                else
                {
                    $temporal_medicamentos_pedidos = 
                    Yii::$app->db->createCommand()
                    ->insert('temporal_medicamentos_pedidos', 
                    [
                        'idmedi'                  => $id_detalle_medi,
                        'cantidad'                => $pedido_cantidad,
                    ])->execute();

                    if($temporal_medicamentos_pedidos)
                    {   
                        return [
                            'data' => [
                                'success'           => true,
                                'message'           => 'Consulta Exitosa',
                                'id_detalle_medi'   => $id_detalle_medi,
                                'nombre'            => $nombre, 
                                'presentacion'      => $presentacion,
                                'idtipo'            => $idtipo,
        
                            ],
                            'code' => 1,
                        ];
                    }
                }
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

    public function actionRemovermedicamento()
    {
        if (Yii::$app->request->isAjax) 
        {

            $data_id_detalle_medi = $_POST['data_id_detalle_medi'];
           
            $remover_medicamento = 
            Yii::$app->db->
            createCommand("DELETE FROM public.temporal_medicamentos_pedidos
            WHERE idmedi=$data_id_detalle_medi")->queryAll();


            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($remover_medicamento)
            {
        
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'El Medicamento Ha Sido Removido',
                ],
                    'code' => 0,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error al remover el medicamento.',
                ],
                    'code' => 0, 
                ];
            }
        }
    }


    public function actionLimpiardatostemporales()
    {
        if (Yii::$app->request->isAjax) 
        {

            $parametro = $_POST['parametro'];
           
                
                $datos_temporales = Yii::$app->db->createCommand()->truncateTable("temporal_medicamentos_pedidos")->execute();
         
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                if($datos_temporales == 0)
                {
            
                    return [
                        'data' => [
                            'success' => true,
                            'message' => 'Los datos temporales fueron removidos',
                    ],
                        'code' => 0,
                    ];
                }
                else
                {
                    return [
                        'data' => [
                            'success' => false,
                            'message' => 'Ocurrió un error al remover los datos temporales.',
                    ],
                        'code' => 0, 
                    ];
                }
            
        }
    }

     public function actionQueryupdate()
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
 
             foreach ($pedidos as $pedidos) 
             {
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


    public function actionUpdate()
    {
        if (Yii::$app->request->isAjax) 
        {
            $idpedi                 = $_POST['idpedi_update'];
            $descripcion            = $_POST['pedido_descripcion_update'];
            //$idmedi                 = $_POST['pedido_idmedi_update'];
            $procedencia            = $_POST['pedido_sede_update'];
            //$cantidad               = $_POST['pedido_cantidad_update'];
            $estatus                = $_POST['pedido_estatus_update'];
            $idusu                  = Yii::$app->user->identity->id;

            /* ACTUALIZAR PEDIDO */
            $update_pedido = Yii::$app->db->createCommand("UPDATE public.pedidos
            SET descripcion='$descripcion'
            WHERE idpedi=$idpedi")->queryAll();

            $update_detalle_pedido = Yii::$app->db->createCommand("UPDATE public.detalle_pedi
            SET procedencia=$procedencia, estatus=$estatus
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
