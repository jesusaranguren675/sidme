<?php

namespace app\controllers;

use Yii;
use app\models\Tipomedicamento;
use app\models\TipomedicamentoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;

/**
 * TipomedicamentoController implements the CRUD actions for Tipomedicamento model.
 */
class TipomedicamentoController extends Controller
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
     * Lists all Tipomedicamento models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Tipomedicamento();
        
        $presentaciones = 
        Yii::$app->db->createCommand("SELECT * FROM tipo_medicamento")->queryAll();

        return $this->render('index', [
            'model'             => $model,
            'presentaciones'    => $presentaciones,
        ]);
    }

    public function actionReport() {

        $presentaciones = 
            Yii::$app->db->createCommand("SELECT * FROM tipo_medicamento
            ")->queryAll();
        
            $mpdf = new mPDF();
            //$mpdf->SetHeader(Html::img('@web/img/cintillo_pdf.jpg')); 
            $mpdf->setFooter('{PAGENO}'); 
            $mpdf->WriteHTML($this->renderPartial('_reportView', ['presentaciones' => $presentaciones]));
            $mpdf->Output();
            exit;
    }

    /**
     * Displays a single Tipomedicamento model.
     * @param int $idtipo Idtipo
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    /*
    public function actionView($idtipo)
    {
        return $this->render('view', [
            'model' => $this->findModel($idtipo),
        ]);
    }
    */

    public function actionView()
    {

        $idtipo = $_POST['data_idtipo'];

        if (Yii::$app->request->isAjax) 
        {
           
            $presentacion_consul = 
            Yii::$app->db->createCommand("SELECT * FROM tipo_medicamento 
            WHERE idtipo=$idtipo")->queryAll();

            foreach ($presentacion_consul as $presentacion) {
                $idtipo         = $presentacion['idtipo'];
                $descripcion    = $presentacion['descripcion'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($presentacion_consul)
            {
                return [
                    'data' => [
                        'success'           => true,
                        'message'           => 'Consulta Exitosa',
                        'idtipo'            => $idtipo,
                        'descripcion'       => $descripcion,
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
     * Creates a new Tipomedicamento model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        if (Yii::$app->request->isAjax) 
        {
            $descripcion            = $_POST['descripcion'];

            /* VALIDACIÓN */
            $consulta_pre = 
            Yii::$app->db->createCommand("SELECT * 
            FROM tipo_medicamento WHERE descripcion='$descripcion'")->queryAll();

            //var_dump($consulta_pre); die();

            if($consulta_pre)
            {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ya existe la presentación.',
                    ],
                    'code' => 0,
                ];
            }
            else
            {
                /* REGISTRAR PRESENTACION */
                $presentaciones = Yii::$app->db->createCommand()->insert('tipo_medicamento', [
                    'descripcion'                  => $descripcion,
                ])->execute();
                /* FIN REGISTRAR PRESENTACIÓN */
            }

            /* FIN VALIDACIÓN */

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($presentaciones)
            {
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Presentación Registrada Exitosamente',
                    ],
                    'code' => 1,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error al registrar la presentación',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
        }

    }

    
    public function actionQueryupdate()
    {

        $data_idtipo = $_POST['data_idtipo'];

        if (Yii::$app->request->isAjax) 
        {
           
            $presentacion_consul = 
            Yii::$app->db->createCommand("SELECT * FROM tipo_medicamento 
            WHERE idtipo=$data_idtipo")->queryAll();

            foreach ($presentacion_consul as $presentacion)
            {
                $descripcion    = $presentacion['descripcion'];
                $idtipo         = $presentacion['idtipo'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($presentacion_consul)
            {
                return [
                    'data' => [
                        'success'           => true,
                        'message'           => 'Consulta Exitosa',
                        'idtipo'            => $idtipo,
                        'descripcion'       => $descripcion,
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
     * Updates an existing Tipomedicamento model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idtipo Idtipo
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        if (Yii::$app->request->isAjax) 
        {

            $idtipo      = $_POST['presentacion_idtipo_update'];
            $descripcion = $_POST['presentacion_descripcion_update'];

            /* ACTUALIZAR PRESENTACION */
            $update_pedido = Yii::$app->db->createCommand("UPDATE public.tipo_medicamento
            SET descripcion='$descripcion'
            WHERE idtipo=$idtipo")->queryAll();
            /* FIN ACTUALIZAR PRESENTACION */


            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($update_pedido)
            {
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Presentación Modificada Exitosamente',
                    ],
                    'code' => 1,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error al modificar la presentación',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
        }
    }

    /**
     * Deletes an existing Tipomedicamento model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idtipo Idtipo
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idtipo)
    {
        $this->findModel($idtipo)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Tipomedicamento model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idtipo Idtipo
     * @return Tipomedicamento the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idtipo)
    {
        if (($model = Tipomedicamento::findOne(['idtipo' => $idtipo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
