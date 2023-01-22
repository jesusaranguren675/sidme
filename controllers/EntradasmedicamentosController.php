<?php

namespace app\controllers;

use Yii;
use app\models\Entradasmedicamentos;
use app\models\EntradasmedicamentosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;

/**
 * EntradasmedicamentosController implements the CRUD actions for Entradasmedicamentos model.
 */
class EntradasmedicamentosController extends Controller
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
     * Lists all Entradasmedicamentos models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new EntradasmedicamentosSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $model = new Entradasmedicamentos();

        

        $entradas_medicamentos = 
        Yii::$app->db->createCommand("SELECT entradas_medicamentos.identrada, 
        entradas_medicamentos.descripcion,
        medicamentos.nombre, tipo_medicamento.descripcion as presentacion,
        detalle_entra.fecha_entrada,
        /*tipo_medicamento.descripcion as presentacion,*/
        detalle_entra.cantidad, sede.nombre as nombre_sede
        FROM
        entradas_medicamentos as entradas_medicamentos 
        join detalle_entra
        as detalle_entra on detalle_entra.identrada=entradas_medicamentos.identrada
        join detalle_medi as detalle_medi
		on detalle_medi.id_detalle_medi=detalle_entra.idmedi
		join medicamentos as medicamentos
		on detalle_medi.idmedi=medicamentos.idmedi
		join tipo_medicamento as tipo_medicamento
		on detalle_medi.idtipo=tipo_medicamento.idtipo
        join sede as sede
        on detalle_entra.procedencia=sede.idsede
        order by entradas_medicamentos.identrada DESC")->queryAll();

        return $this->render('index', [
            'searchModel'               => $searchModel,
            'dataProvider'              => $dataProvider,
            'entradas_medicamentos'     => $entradas_medicamentos,
            'model'                     => $model,
        ]);
    }

 

    public function actionReport() {

        $recepciones = 
            Yii::$app->db->createCommand("SELECT entradas_medicamentos.identrada, 
            entradas_medicamentos.descripcion,
            medicamentos.nombre, tipo_medicamento.descripcion as presentacion, detalle_entra.fecha_entrada,
            /*tipo_medicamento.descripcion as presentacion,*/
            detalle_entra.cantidad, sede.nombre as nombre_sede
            FROM
            entradas_medicamentos as entradas_medicamentos 
            join detalle_entra
            as detalle_entra on detalle_entra.identrada=entradas_medicamentos.identrada
            join detalle_medi as detalle_medi
            on detalle_medi.id_detalle_medi=detalle_entra.idmedi
            join medicamentos as medicamentos
            on detalle_medi.idmedi=medicamentos.idmedi
            join tipo_medicamento as tipo_medicamento
            on detalle_medi.idtipo=tipo_medicamento.idtipo
            join sede as sede
            on detalle_entra.procedencia=sede.idsede")->queryAll();
        
            $mpdf = new mPDF();
            //$mpdf->SetHeader(Html::img('@web/img/cintillo_pdf.jpg')); 
            $mpdf->setFooter('{PAGENO}'); 
            $mpdf->WriteHTML($this->renderPartial('_reportView', ['recepciones' => $recepciones]));
            $mpdf->Output();
            exit;
    }

    /**
     * Displays a single Entradasmedicamentos model.
     * @param int $identrada Identrada
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {

        $identrada = $_POST['data_identrada'];

        if (Yii::$app->request->isAjax) 
        {
           
            $entradas_medicamentos_consul = 
            Yii::$app->db->createCommand("SELECT entradas_medicamentos.identrada, 
            entradas_medicamentos.descripcion,
            medicamentos.nombre, tipo_medicamento.descripcion as presentacion, detalle_entra.fecha_entrada,
            /*tipo_medicamento.descripcion as presentacion,*/
            detalle_entra.cantidad
            FROM
            entradas_medicamentos as entradas_medicamentos 
            join detalle_entra
            as detalle_entra on detalle_entra.identrada=entradas_medicamentos.identrada
            join detalle_medi as detalle_medi
            on detalle_medi.id_detalle_medi=detalle_entra.idmedi
            join medicamentos as medicamentos
            on detalle_medi.idmedi=medicamentos.idmedi
            join tipo_medicamento as tipo_medicamento
            on detalle_medi.idtipo=tipo_medicamento.idtipo
            where entradas_medicamentos.identrada=$identrada")->queryAll();

            foreach ($entradas_medicamentos_consul as $entradas_medicamentos) {
                $identrada      = $entradas_medicamentos['identrada'];
                $descripcion    = $entradas_medicamentos['descripcion'];
                $nombre         = $entradas_medicamentos['nombre'];
                $presentacion   = $entradas_medicamentos['presentacion'];
                $cantidad       = $entradas_medicamentos['cantidad'];
                $fecha          = $entradas_medicamentos['fecha_entrada'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($entradas_medicamentos_consul)
            {
                return [
                    'data' => [
                        'success'           => true,
                        'message'           => 'Consulta Exitosa',
                        'identrada'         => $identrada,
                        'descripcion'       => $descripcion,
                        'nombre'            => $nombre, 
                        'presentacion'      => $presentacion,
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
                        'message' => 'Ocurrió un error en la consulta',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
        }

    }

    /**
     * Creates a new Entradasmedicamentos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Entradasmedicamentos();

    
        if (Yii::$app->request->isAjax) 
        {
            $descripcion    = $_POST['descripcion'];
            $idmedi         = $_POST['idmedi'];
            $idsede         = $_POST['idsede'];
            $cantidad       = $_POST['cantidad'];
            $idusu          = Yii::$app->user->identity->id;
            $fecha_entrada  = date('d/m/y');


            $entradas_medicamentos = Yii::$app->db->createCommand()->insert('entradas_medicamentos', [
                'descripcion'                  => $descripcion,
                'idusu'                        => $idusu,
            ])->execute();

            $identrada = Yii::$app->db->getLastInsertID();

            $detalle_entra = 
            Yii::$app->db->createCommand("INSERT INTO public.detalle_entra(
                idmedi, procedencia, cantidad, identrada, fecha_entrada)
                VALUES ($idmedi, $idsede, $cantidad, $identrada, '$fecha_entrada')")->queryAll();

            $consulta_almacen = 
            Yii::$app->db->createCommand("SELECT * 
            FROM almacen_general WHERE idmedi=$idmedi")->queryAll();

            foreach ($consulta_almacen as $consulta_almacen) {
                $unidades = $consulta_almacen['cantidad'];
                $idal_gral = $consulta_almacen['idal_gral'];
            }

            if($consulta_almacen)
            {
                $suma = $unidades + $cantidad;

                $update_almacen = 
                Yii::$app->db->createCommand("UPDATE public.almacen_general
                SET cantidad=$suma
                WHERE idal_gral= $idal_gral")->queryAll();
            }
            else{
                $almacen_general = 
                Yii::$app->db->createCommand("INSERT INTO public.almacen_general(
                    idmedi, cantidad)
                    VALUES ($idmedi, $cantidad)")->queryAll();
            }

           

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($detalle_entra)
            {
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Medicamento Registrado Exitosamente',
                    ],
                    'code' => 1,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error al registrar el medicamento',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
        }

        return $this->render('create', [
            'model'         => $model,
        ]);
    }

    public function actionQueryupdate()
    {
        
        $identrada = $_POST['data_identrada'];

        if (Yii::$app->request->isAjax) 
        {
           
            $recepciones = 
            Yii::$app->db->createCommand("SELECT entradas_medicamentos.identrada, 
            entradas_medicamentos.descripcion,
            medicamentos.nombre, tipo_medicamento.descripcion as presentacion, detalle_entra.fecha_entrada,
            /*tipo_medicamento.descripcion as presentacion,*/
            detalle_entra.cantidad, medicamentos, 
            detalle_entra.idmedi, detalle_entra.procedencia,
            sede.nombre as nombre_sede
            FROM
            entradas_medicamentos as entradas_medicamentos 
            join detalle_entra
            as detalle_entra on detalle_entra.identrada=entradas_medicamentos.identrada
            join detalle_medi as detalle_medi
            on detalle_medi.id_detalle_medi=detalle_entra.idmedi
            join medicamentos as medicamentos
            on detalle_medi.idmedi=medicamentos.idmedi
            join tipo_medicamento as tipo_medicamento
            on detalle_medi.idtipo=tipo_medicamento.idtipo
            join sede as sede
            on sede.idsede=detalle_entra.procedencia
            where entradas_medicamentos.identrada=$identrada")->queryAll();

            foreach ($recepciones as $recepciones) {
                $identrada         = $recepciones['identrada'];
                $idmedi            = $recepciones['idmedi'];
                $procedencia       = $recepciones['procedencia'];
                $nombre_sede       = $recepciones['nombre_sede'];
                $descripcion       = $recepciones['descripcion'];
                $nombre            = $recepciones['nombre'];
                $presentacion      = $recepciones['presentacion'];
                $cantidad          = $recepciones['cantidad'];
                $fecha_entrada     = $recepciones['fecha_entrada'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($recepciones)
            {
                return [
                    'data' => [
                        'success'           => true,
                        'message'           => 'Consulta Exitosa',
                        'identrada'         => $identrada,
                        'idmedi'            => $idmedi,
                        'procedencia'       => $procedencia,
                        'nombre_sede'       => $nombre_sede,
                        'descripcion'       => $descripcion,
                        'nombre'            => $nombre, 
                        'presentacion'      => $presentacion,
                        'cantidad'          => $cantidad,
                        'fecha_entrada'     => $fecha_entrada,  
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
     * Updates an existing Entradasmedicamentos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $identrada Identrada
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {

        if (Yii::$app->request->isAjax) 
        {
            $identrada                  = $_POST['identrada'];
            $descripcion                = $_POST['descripcion'];
            $idmedi                     = $_POST['idmedi'];
            $idsede                     = $_POST['idsede'];
            $cantidad                   = $_POST['cantidad'];
            $idusu                      = Yii::$app->user->identity->id;

            /* ACTUALIZAR ENTRADA DE MEDICAMENTO */
            $update_entrada = Yii::$app->db->createCommand("UPDATE public.entradas_medicamentos
            SET identrada=$identrada, descripcion='$descripcion', idusu=$idusu
            WHERE identrada=$identrada")->queryAll();

            $update_detalle_entrada = Yii::$app->db->createCommand("UPDATE public.detalle_entra
            SET idmedi=$idmedi, procedencia=$idsede, cantidad=$cantidad
            WHERE identrada=$identrada")->queryAll();
            /* FIN ACTUALIZAR ENTRADA DE MEDICAMENTO */


            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($update_entrada && $update_detalle_entrada)
            {
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Recepción Modificada Exitosamente',
                    ],
                    'code' => 1,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error al modificar la recepción',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
        }

    }

    /**
     * Deletes an existing Entradasmedicamentos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $identrada Identrada
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($identrada)
    {
        $this->findModel($identrada)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Entradasmedicamentos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $identrada Identrada
     * @return Entradasmedicamentos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($identrada)
    {
        if (($model = Entradasmedicamentos::findOne(['identrada' => $identrada])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
