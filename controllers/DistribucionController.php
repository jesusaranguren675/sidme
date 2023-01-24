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

        $pedidos = 
        Yii::$app->db->createCommand("SELECT pedidos.idpedi, 
        pedidos.descripcion,
        medicamentos.nombre,
        detalle_pedi.procedencia,
        sede.nombre AS destino,
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
        JOIN sede AS sede
        ON sede.idsede=detalle_pedi.procedencia
        WHERE estatus=1")->queryAll();

        $distribuciones = 
        Yii::$app->db->createCommand("SELECT distribucion.iddis, detalle_dis.correlativo, sede.nombre AS destino, 
        distribucion.descripcion, detalle_dis.fecha 
        FROM distribucion AS distribucion
        JOIN detalle_dis AS detalle_dis
        ON detalle_dis.iddis=distribucion.iddis
        JOIN sede AS sede
        ON sede.idsede=detalle_dis.destino")->queryAll();

        //var_dump($distribuciones); die();
        return $this->render('index', [
            'searchModel'                   => $searchModel,
            'dataProvider'                  => $dataProvider,
            'pedidos'                       => $pedidos,
            'distribuciones'                => $distribuciones,
            'model'                         => $model,
        ]);
    }

    public function actionReport() {

        $distribuciones = 
        Yii::$app->db->createCommand("SELECT distribucion.iddis, detalle_dis.correlativo, sede.nombre AS destino, 
        distribucion.descripcion, detalle_dis.fecha 
        FROM distribucion AS distribucion
        JOIN detalle_dis AS detalle_dis
        ON detalle_dis.iddis=distribucion.iddis
        JOIN sede AS sede
        ON sede.idsede=detalle_dis.destino")->queryAll();
        
            $mpdf = new mPDF();
            //$mpdf->SetHeader(Html::img('@web/img/cintillo_pdf.jpg')); 
            $mpdf->setFooter('{PAGENO}'); 
            $mpdf->WriteHTML($this->renderPartial('_reportView', ['distribuciones' => $distribuciones]));
            $mpdf->Output();
            exit;
    }

    public function actionNotaentrega($id) {

        $distribucion = 
            Yii::$app->db->createCommand("SELECT distribucion.iddis, detalle_dis.correlativo, 
            sede.nombre AS destino, detalle_dis.fecha, distribucion.descripcion
            FROM distribucion AS distribucion
            JOIN detalle_dis AS detalle_dis
            ON detalle_dis.iddis=distribucion.iddis
            JOIN sede AS sede
            ON sede.idsede=detalle_dis.destino
            WHERE distribucion.iddis=$id")->queryAll();

        $medicamentos = 
        Yii::$app->db->createCommand("SELECT md.id_mdist, medicamentos.nombre, tipo_medicamento.descripcion AS presentacion, 
        md.cantidad FROM medicamentos_distribuidos AS md
        JOIN distribucion AS distribucion
        ON distribucion.iddis=md.iddis
        JOIN detalle_medi AS detalle_medi
        ON detalle_medi.id_detalle_medi=md.idmedi
        JOIN medicamentos AS medicamentos
        ON medicamentos.idmedi=detalle_medi.idmedi
        JOIN tipo_medicamento AS tipo_medicamento
        ON tipo_medicamento.idtipo=detalle_medi.idtipo
        WHERE distribucion.iddis=$id")->queryAll();

            foreach ($distribucion as $distribucion_p) {
                $correlativo = $distribucion_p['correlativo'];
            }

            $mpdf = new mPDF();
            //$mpdf->SetHeader(Html::img('@web/img/cintillo_pdf.jpg')); 
            $mpdf->setFooter('{PAGENO}'); 
            $mpdf->WriteHTML($this->renderPartial('_notaEntrega', ['distribucion' => $distribucion, 'correlativo' => $correlativo, 'medicamentos' => $medicamentos]));
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

    public function actionViewpedi()
    {
        $data_idpedi = $_POST['data_idpedi'];

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
            WHERE pedidos.idpedi=$data_idpedi")->queryAll();

            //var_dump($pedidos); die();

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

            //var_dump($medicamentos); die();
           
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
                        'medicamentos'       => $medicamentos,
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

    public function actionAprobar()
    {
        if (Yii::$app->request->isAjax) 
        {
            $idpedi                 = $_POST['idpedi_dis'];
            $descripcion            = $_POST['descripcion_dis'];
            $idusu                  = Yii::$app->user->identity->id;
            $fecha                  = date('d/m/y');
            $dia                    = date('d');
            $mes                    = date('m');
            $anio                   = date('y');

            $consulta_destino = 
            Yii::$app->db->createCommand("SELECT sede.idsede from pedidos as pedidos
            join detalle_pedi
            on detalle_pedi.idpedi=pedidos.idpedi
            join sede as sede
            on sede.idsede=detalle_pedi.procedencia
            where pedidos.idpedi=$idpedi")->queryAll();

            foreach ($consulta_destino as $consulta_destino)
            {
                $destino = $consulta_destino['idsede'];
            }
            
            /* REGISTRAR DISTRIBUCIÓN */

            $val_multiples_medicamentos = 
            Yii::$app->db->createCommand("SELECT * FROM medicamentos_pedidos")->queryAll();

            foreach ($val_multiples_medicamentos as $val_multiples_medicamentos) {
                $idmedi_mltp         = $val_multiples_medicamentos['idmedi'];
                $cantidad_mltp       = $val_multiples_medicamentos['cantidad'];

                $consulta_almacen = 
                Yii::$app->db->createCommand("SELECT almacen_general.idmedi, 
                medicamentos.nombre, tipo_medicamento.descripcion AS presentacion,
                almacen_general.cantidad
                FROM almacen_general AS almacen_general
                JOIN detalle_medi AS detalle_medi
                ON detalle_medi.id_detalle_medi=almacen_general.idmedi
                JOIN medicamentos AS medicamentos
                ON medicamentos.idmedi=detalle_medi.idmedi
                JOIN tipo_medicamento AS tipo_medicamento
                ON tipo_medicamento.idtipo=detalle_medi.idtipo
                WHERE almacen_general.idmedi=$idmedi_mltp")->queryAll();

                foreach ($consulta_almacen as $consulta_almacen)
                {
                    $unidades       = $consulta_almacen['cantidad'];
                    $nombre_medi    = $consulta_almacen['nombre'];
                    $nombre_pre     = $consulta_almacen['presentacion'];
                }
                
                if($consulta_almacen == true)
                {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                    if($unidades < $cantidad_mltp )
                    {
                        return [
                            'data' => [
                                'success' => false,
                                'message' => 'No contamos con la cantidad solicitada',
                                'info'    => 'No contamos con la cantidad solicitada para el medicamento '.$nombre_medi.' '.$nombre_pre.'',
                        ],
                            'code' => 0, // Some semantic codes that you know them for yourself
                        ];
                        exit;
                    }
                }

            }

            /* VALIDAR QUE LOS MEDICAMENTOS EXISTAN EN EL ALMACEN */

            
            $val_multiples_medicamentos = 
            Yii::$app->db->createCommand("SELECT * FROM medicamentos_pedidos")->queryAll();

            foreach ($val_multiples_medicamentos as $val_multiples_medicamentos) {
                $idmedi_mltp         = $val_multiples_medicamentos['idmedi'];
                $cantidad_mltp       = $val_multiples_medicamentos['cantidad'];

                $medicamento_registrado = 
                Yii::$app->db->createCommand("SELECT
                detalle_medi.id_detalle_medi,
                medicamentos.nombre, 
                tipo_medicamento.descripcion AS presentacion
                FROM detalle_medi AS detalle_medi
                JOIN medicamentos AS medicamentos
                ON medicamentos.idmedi=detalle_medi.idmedi
                JOIN tipo_medicamento AS tipo_medicamento
                ON detalle_medi.idtipo=tipo_medicamento.idtipo
                WHERE detalle_medi.id_detalle_medi=$idmedi_mltp")->queryAll();

                foreach ($medicamento_registrado as $medicamento_registrado)
                {
                    $nombre_medicamento_registrado   = $medicamento_registrado['nombre'];
                    $nombre_presentacion_registrada  = $medicamento_registrado['presentacion'];
                }

                $consulta_almacen = 
                Yii::$app->db->createCommand("SELECT almacen_general.idmedi, 
                medicamentos.nombre, tipo_medicamento.descripcion AS presentacion,
                almacen_general.cantidad
                FROM almacen_general AS almacen_general
                JOIN detalle_medi AS detalle_medi
                ON detalle_medi.id_detalle_medi=almacen_general.idmedi
                JOIN medicamentos AS medicamentos
                ON medicamentos.idmedi=detalle_medi.idmedi
                JOIN tipo_medicamento AS tipo_medicamento
                ON tipo_medicamento.idtipo=detalle_medi.idtipo
                WHERE almacen_general.idmedi=$idmedi_mltp")->queryAll();

                foreach ($consulta_almacen as $consulta_almacen)
                {
                    $unidades       = $consulta_almacen['cantidad'];
                    $nombre_medi    = $consulta_almacen['nombre'];
                    $nombre_pre     = $consulta_almacen['presentacion'];
                }
                
                if($consulta_almacen == true)
                {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                    if($unidades < $cantidad_mltp )
                    {
                        return [
                            'data' => [
                                'success' => false,
                                'message' => 'No contamos con la cantidad solicitada',
                                'info'    => 'No contamos con la cantidad solicitada para el medicamento '.$nombre_medi.' '.$nombre_pre.'',
                        ],
                            'code' => 0, // Some semantic codes that you know them for yourself
                        ];
                        exit;
                    }
                }
                else
                {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                    return [
                        'data' => [
                            'success' => false,
                            'message' => 'El medicamento no se encuentra registrado en almacen',
                            'info'    => 'El medicamento '.$nombre_medicamento_registrado.' '.$nombre_presentacion_registrada.' no ha sigo registrado en el almacen.',
                    ],
                        'code' => 0, // Some semantic codes that you know them for yourself
                    ];
                    exit;
                }

            }

            $distribucion = Yii::$app->db->createCommand()->insert('distribucion', [
                'descripcion'                  => $descripcion,
                'idusu'                        => $idusu,
            ])->execute();

            $iddis = Yii::$app->db->getLastInsertID();

            $correlativo = "$iddis"."-"."$dia$mes$anio";

            $detalle_dis = 
            Yii::$app->db->createCommand("INSERT INTO public.detalle_dis(
                iddis, destino, fecha, correlativo)
                VALUES ($iddis, $destino, '$fecha', '$correlativo')")->queryAll();
            
                /* REGISTRAR MULTIPLES MEDICAMENTOS */

            $medicamentos_pedidos = 
            Yii::$app->db->createCommand("SELECT * FROM medicamentos_pedidos
            WHERE idpedi=$idpedi")->queryAll();

            foreach ($medicamentos_pedidos as $medicamentos_pedidos) 
            {
                $idmedi_mltp         = $medicamentos_pedidos['idmedi'];
                $cantidad_mltp       = $medicamentos_pedidos['cantidad'];

                $insert_medicamentos_distribuidos = 
                Yii::$app->db->createCommand("INSERT INTO public.medicamentos_distribuidos(
                iddis, idmedi, cantidad)
                VALUES ($iddis, $idmedi_mltp, $cantidad_mltp);")->queryAll();

                $consulta_almacen = 
                Yii::$app->db->createCommand("SELECT *
                FROM almacen_general AS almacen_general
                WHERE idmedi=$idmedi_mltp")->queryAll();

                foreach ($consulta_almacen as $consulta_almacen)
                {
                    $unidades = $consulta_almacen['cantidad'];
                    $idal_gral = $consulta_almacen['idal_gral'];
                }

                $resta = $unidades - $cantidad_mltp;

                $update_almacen = 
                Yii::$app->db->createCommand("UPDATE public.almacen_general
                SET cantidad=$resta
                WHERE idmedi=$idmedi_mltp")->queryAll();
            }

            /* FIN REGISTRAR DISTRIBUCIÓN */

            /* ACTUALIZAR PEDIDO */
            $update_detalle_pedido = Yii::$app->db->createCommand("UPDATE public.detalle_pedi
            SET estatus=4
            WHERE idpedi=$idpedi")->queryAll();
            /* FIN ACTUALIZAR PEDIDO */


            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($update_detalle_pedido)
            {
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Distribución Realizada.',
                    ],
                    'code' => 1,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error al realizar la distribución.',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
        }
    }

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
                temporal_medicamentos_distribuidos WHERE idmedi=$id_detalle_medi")->queryAll();

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
                    ->insert('temporal_medicamentos_distribuidos', 
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

    public function actionLimpiardatostemporales()
    {
        if (Yii::$app->request->isAjax) 
        {

            $parametro = $_POST['parametro'];
           
                
                $datos_temporales = Yii::$app->db->createCommand()->truncateTable("temporal_medicamentos_distribuidos")->execute();
         
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

            //$idmedi         = $_POST['idmedi'];
            $descripcion    = strtolower($_POST['descripcion']);
            $destino        = $_POST['destino'];
            //$cantidad       = $_POST['cantidad'];
            $idusu          = Yii::$app->user->identity->id;
            $fecha          = date('d/m/y');
            $dia            = date('d');
            $mes            = date('m');
            $anio           = date('y');

            /* VALIDAR QUE EXISTA MINIMO UN MEDICAMENTO EN LA DISTRIBUCIÓN */

            $consulta_almacen = 
            Yii::$app->db->createCommand("SELECT * FROM 
            temporal_medicamentos_distribuidos")->queryAll();

            if($consulta_almacen == true)
            {
                
            }
            else
            {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                return [
                    'data' => [
                        'success' => false,
                        'message' => 'No existen medicamentos en la lista',
                        'info'    => 'Debes registrar minimo un medicamento a la lista de distribución.'
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
                exit;
            }

            /* VALIDAR QUE EXISTA LA CANTIDAD DE MEDICAMENTOS SOLICITADA */

            $val_multiples_medicamentos = 
            Yii::$app->db->createCommand("SELECT * FROM temporal_medicamentos_distribuidos")->queryAll();

            foreach ($val_multiples_medicamentos as $val_multiples_medicamentos) {
                $idmedi_mltp         = $val_multiples_medicamentos['idmedi'];
                $cantidad_mltp       = $val_multiples_medicamentos['cantidad'];

                $consulta_almacen = 
                Yii::$app->db->createCommand("SELECT almacen_general.idmedi, 
                medicamentos.nombre, tipo_medicamento.descripcion AS presentacion,
                almacen_general.cantidad
                FROM almacen_general AS almacen_general
                JOIN detalle_medi AS detalle_medi
                ON detalle_medi.id_detalle_medi=almacen_general.idmedi
                JOIN medicamentos AS medicamentos
                ON medicamentos.idmedi=detalle_medi.idmedi
                JOIN tipo_medicamento AS tipo_medicamento
                ON tipo_medicamento.idtipo=detalle_medi.idtipo
                WHERE almacen_general.idmedi=$idmedi_mltp")->queryAll();

                foreach ($consulta_almacen as $consulta_almacen)
                {
                    $unidades       = $consulta_almacen['cantidad'];
                    $nombre_medi    = $consulta_almacen['nombre'];
                    $nombre_pre     = $consulta_almacen['presentacion'];
                }
                
                if($consulta_almacen == true)
                {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                    if($unidades < $cantidad_mltp )
                    {
                        return [
                            'data' => [
                                'success' => false,
                                'message' => 'No contamos con la cantidad solicitada',
                                'info'    => 'No contamos con la cantidad solicitada para el medicamento '.$nombre_medi.' '.$nombre_pre.'',
                        ],
                            'code' => 0, // Some semantic codes that you know them for yourself
                        ];
                        exit;
                    }
                }

            }

            /* VALIDAR QUE LOS MEDICAMENTOS EXISTAN EN EL ALMACEN */

            
            $val_multiples_medicamentos = 
            Yii::$app->db->createCommand("SELECT * FROM temporal_medicamentos_distribuidos")->queryAll();

            foreach ($val_multiples_medicamentos as $val_multiples_medicamentos) {
                $idmedi_mltp         = $val_multiples_medicamentos['idmedi'];
                $cantidad_mltp       = $val_multiples_medicamentos['cantidad'];

                $medicamento_registrado = 
                Yii::$app->db->createCommand("SELECT
                detalle_medi.id_detalle_medi,
                medicamentos.nombre, 
                tipo_medicamento.descripcion AS presentacion
                FROM detalle_medi AS detalle_medi
                JOIN medicamentos AS medicamentos
                ON medicamentos.idmedi=detalle_medi.idmedi
                JOIN tipo_medicamento AS tipo_medicamento
                ON detalle_medi.idtipo=tipo_medicamento.idtipo
                WHERE detalle_medi.id_detalle_medi=$idmedi_mltp")->queryAll();

                foreach ($medicamento_registrado as $medicamento_registrado)
                {
                    $nombre_medicamento_registrado   = $medicamento_registrado['nombre'];
                    $nombre_presentacion_registrada  = $medicamento_registrado['presentacion'];
                }

                $consulta_almacen = 
                Yii::$app->db->createCommand("SELECT almacen_general.idmedi, 
                medicamentos.nombre, tipo_medicamento.descripcion AS presentacion,
                almacen_general.cantidad
                FROM almacen_general AS almacen_general
                JOIN detalle_medi AS detalle_medi
                ON detalle_medi.id_detalle_medi=almacen_general.idmedi
                JOIN medicamentos AS medicamentos
                ON medicamentos.idmedi=detalle_medi.idmedi
                JOIN tipo_medicamento AS tipo_medicamento
                ON tipo_medicamento.idtipo=detalle_medi.idtipo
                WHERE almacen_general.idmedi=$idmedi_mltp")->queryAll();

                foreach ($consulta_almacen as $consulta_almacen)
                {
                    $unidades       = $consulta_almacen['cantidad'];
                    $nombre_medi    = $consulta_almacen['nombre'];
                    $nombre_pre     = $consulta_almacen['presentacion'];
                }
                
                if($consulta_almacen == true)
                {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                    if($unidades < $cantidad_mltp )
                    {
                        return [
                            'data' => [
                                'success' => false,
                                'message' => 'No contamos con la cantidad solicitada',
                                'info'    => 'No contamos con la cantidad solicitada para el medicamento '.$nombre_medi.' '.$nombre_pre.'',
                        ],
                            'code' => 0, // Some semantic codes that you know them for yourself
                        ];
                        exit;
                    }
                }
                else
                {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                    return [
                        'data' => [
                            'success' => false,
                            'message' => 'El medicamento no se encuentra registrado en almacen',
                            'info'    => 'El medicamento '.$nombre_medicamento_registrado.' '.$nombre_presentacion_registrada.' no ha sigo registrado en el almacen.',
                    ],
                        'code' => 0, // Some semantic codes that you know them for yourself
                    ];
                    exit;
                }

            }


            /* REGISTRAR DISTRIBUCIÓN */
            $distribucion = Yii::$app->db->createCommand()->insert('distribucion', [
                'descripcion'                  => $descripcion,
                'idusu'                        => $idusu,
            ])->execute();

            $iddis = Yii::$app->db->getLastInsertID();

            $correlativo = "$iddis"."-"."$dia$mes$anio";

            $detalle_dis = 
            Yii::$app->db->createCommand("INSERT INTO public.detalle_dis(
                iddis, destino, fecha, correlativo)
                VALUES ($iddis, $destino, '$fecha', '$correlativo')")->queryAll();
            /* FIN REGISTRAR DISTRIBUCIÓN */


            /* REGISTRAR MULTIPLES MEDICAMENTOS */

            $temporal_multiples_medicamentos = 
            Yii::$app->db->createCommand("SELECT * FROM temporal_medicamentos_distribuidos")->queryAll();

            foreach ($temporal_multiples_medicamentos as $temporal_multiples_medicamentos) {
                $idmedi_mltp         = $temporal_multiples_medicamentos['idmedi'];
                $cantidad_mltp       = $temporal_multiples_medicamentos['cantidad'];

                $insert_multiples_medicamentos = 
                Yii::$app->db->createCommand("INSERT INTO public.medicamentos_distribuidos(
                iddis, idmedi, cantidad)
                VALUES ($iddis, $idmedi_mltp, $cantidad_mltp);")->queryAll();

                $consulta_almacen = 
                Yii::$app->db->createCommand("SELECT *
                FROM almacen_general AS almacen_general
                WHERE idmedi=$idmedi_mltp")->queryAll();

                foreach ($consulta_almacen as $consulta_almacen)
                {
                    $unidades = $consulta_almacen['cantidad'];
                    $idal_gral = $consulta_almacen['idal_gral'];
                }

                $resta = $unidades - $cantidad_mltp;

                $update_almacen = 
                Yii::$app->db->createCommand("UPDATE public.almacen_general
                SET cantidad=$resta
                WHERE idmedi=$idmedi_mltp")->queryAll();

            }

            /* FIN REGISTRAR MULTIPLES MEDICAMENTOS */

            $distribucion = 
            Yii::$app->db->createCommand("SELECT distribucion.iddis, detalle_dis.correlativo, detalle_dis.destino, 
            distribucion.descripcion, detalle_dis.fecha 
            FROM distribucion AS distribucion
            JOIN detalle_dis AS detalle_dis
            ON detalle_dis.iddis=distribucion.iddis
            WHERE detalle_dis.iddis=$iddis")->queryAll();

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

    public function actionRemovermedicamento()
    {
        if (Yii::$app->request->isAjax) 
        {

            $data_id_detalle_medi = $_POST['data_id_detalle_medi'];
           
            $remover_medicamento = 
            Yii::$app->db->
            createCommand("DELETE FROM public.temporal_medicamentos_distribuidos
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
            WHERE almacen_general.idmedi=$parametro")->queryAll();

            if(empty($unidades))
            {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                $unidades = false;
                return [
                    'data' => [
                        'success'       => true,
                        'message'       => 'Consulta exitosa.',
                        'unidades'      =>  0,
                    ],
                    'code' => 0,
                ];
                exit;
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
