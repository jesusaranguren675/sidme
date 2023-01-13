<?php

namespace app\controllers;

use Yii;
use app\models\Sede;
use app\models\SedeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;

/**
 * SedeController implements the CRUD actions for Sede model.
 */
class SedeController extends Controller
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
     * Lists all Sede models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Sede();
        $searchModel = new SedeSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $sedes = 
        Yii::$app->db->createCommand("SELECT idsede, nombre, ubicacion, telefono, correo
        FROM public.sede;")->queryAll();

        return $this->render('index', [
            'searchModel'       => $searchModel,
            'dataProvider'      => $dataProvider,
            'model'             => $model,
            'sedes'             => $sedes
        ]);
    }

    public function actionReport() {

        $sedes = 
            Yii::$app->db->createCommand("SELECT idsede, nombre, ubicacion, telefono, correo
            FROM public.sede;")->queryAll();
        
            $mpdf = new mPDF();
            //$mpdf->SetHeader(Html::img('@web/img/cintillo_pdf.jpg')); 
            $mpdf->setFooter('{PAGENO}'); 
            $mpdf->WriteHTML($this->renderPartial('_reportView', ['sedes' => $sedes]));
            $mpdf->Output();
            exit;
    }
    /**
     * Displays a single Sede model.
     * @param int $idsede Idsede
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $idsede = $_POST['data_idsede'];

        if (Yii::$app->request->isAjax) 
        {
           
            $sedes_consul = 
            Yii::$app->db->createCommand("SELECT idsede, nombre, ubicacion, telefono, correo
            FROM public.sede
            WHERE idsede=$idsede")->queryAll();

            //var_dump($sedes_consul); die();

            foreach ($sedes_consul as $sedes) {
                $idsede         = $sedes['idsede'];
                $nombre         = $sedes['nombre'];
                $ubicacion      = $sedes['ubicacion'];
                $telefono       = $sedes['telefono'];
                $correo         = $sedes['correo'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($sedes_consul)
            {
                return [
                    'data' => [
                        'success'           => true,
                        'message'           => 'Consulta Exitosa',
                        'idsede'            => $idsede,
                        'nombre'            => $nombre,
                        'ubicacion'         => $ubicacion, 
                        'telefono'          => $telefono,
                        'correo'            => $correo,
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
     * Creates a new Sede model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Sede();

    
        if (Yii::$app->request->isAjax) 
        {
            $nombre     = $_POST['nombre'];
            $ubicacion  = $_POST['ubicacion'];
            $telefono   = $_POST['telefono'];
            $correo     = $_POST['correo'];

            /* VALIDACIÓN */
            $consulta_sede = 
            Yii::$app->db->createCommand("SELECT idsede, nombre, ubicacion, telefono, correo
            FROM public.sede
            WHERE nombre='$nombre' or correo='$correo'")->queryAll();

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($consulta_sede)
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'La Sede Ya Existe.',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
            else
            {
                $sede = Yii::$app->db->createCommand()->insert('sede', [
                    'nombre'                  => $nombre,
                    'ubicacion'               => $ubicacion,
                    'telefono'                => $telefono,
                    'correo'                  => $correo,
                ])->execute();
    
    
                if($sede)
                {
                    return [
                        'data' => [
                            'success' => true,
                            'message' => 'Sede Registrada Exitosamente',
                        ],
                        'code' => 1,
                    ];
                }
                else
                {
                    return [
                        'data' => [
                            'success' => false,
                            'message' => 'Ocurrió un error al registrar la sede',
                    ],
                        'code' => 0, // Some semantic codes that you know them for yourself
                    ];
                }
            }
        }


        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionQueryupdate()
    {

        $idsede= $_POST['data_idsede'];

        if (Yii::$app->request->isAjax) 
        {

            $sedes_consul = 
            Yii::$app->db->createCommand("SELECT idsede, nombre, ubicacion, telefono, correo
            FROM public.sede
            WHERE idsede=$idsede")->queryAll();

            //var_dump($sedes_consul); die();

            foreach ($sedes_consul as $sedes) {
                $idsede         = $sedes['idsede'];
                $nombre         = $sedes['nombre'];
                $ubicacion      = $sedes['ubicacion'];
                $telefono       = $sedes['telefono'];
                $correo         = $sedes['correo'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($sedes_consul)
            {
                return [
                    'data' => [
                        'success'           => true,
                        'message'           => 'Consulta Exitosa',
                        'idsede'            => $idsede,
                        'nombre'            => $nombre,
                        'ubicacion'         => $ubicacion, 
                        'telefono'          => $telefono,
                        'correo'            => $correo,
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
     * Updates an existing Sede model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idsede Idsede
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {

        if (Yii::$app->request->isAjax) 
        {
            $idsede            = $_POST['idsede'];
            $nombre            = $_POST['nombre'];
            $ubicacion         = $_POST['ubicacion'];
            $telefono          = $_POST['telefono'];
            $correo            = $_POST['correo'];

            /* VALIDACIÓN */
            $consulta_sede = 
            Yii::$app->db->createCommand("SELECT idsede, nombre, ubicacion, telefono, correo
            FROM public.sede
            WHERE nombre='$nombre'")->queryAll();
            
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
            if($consulta_sede)
            {
                return [
                    'data' => [
                    'success' => false,
                    'message' => 'La Sede Ya Existe.',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
            else
            {
                /* ACTUALIZAR PEDIDO */
                $update_sede = Yii::$app->db->createCommand("UPDATE public.sede
                SET nombre='$nombre', ubicacion='$ubicacion', telefono='$telefono', correo='$correo'
                WHERE idsede=$idsede")->queryAll();
                /* FIN ACTUALIZAR PEDIDO */


                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                if($update_sede)
                {
                    return [
                        'data' => [
                            'success' => true,
                            'message' => 'Sede Modificada Exitosamente',
                        ],
                        'code' => 1,
                    ];
                }
                else
                {
                    return [
                        'data' => [
                            'success' => false,
                            'message' => 'Ocurrió un error al modificar la sede',
                    ],
                        'code' => 0, // Some semantic codes that you know them for yourself
                    ];
                }
            }
        }
    }

    /**
     * Deletes an existing Sede model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idsede Idsede
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idsede)
    {
        $this->findModel($idsede)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sede model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idsede Idsede
     * @return Sede the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idsede)
    {
        if (($model = Sede::findOne(['idsede' => $idsede])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
