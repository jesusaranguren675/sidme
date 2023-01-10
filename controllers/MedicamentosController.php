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

        $model = new Medicamentos();
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
            'model'                     => $model,
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

        if (Yii::$app->request->isAjax) 
        {
            $nombre         = $_POST['nombre'];
            $presentacion   = $_POST['presentacion'];
            /* VALIDACIÓN */
            $consulta_medicamento = 
            Yii::$app->db->createCommand("SELECT * 
            FROM medicamentos WHERE nombre='$nombre'")->queryAll();

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($consulta_medicamento)
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'El Medicamento Ya Existe.',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
            else{
                /* REGISTRAR MEDICAMENTO */
                $medicamento = Yii::$app->db->createCommand()->insert('medicamentos', [
                    'nombre'                  => "$nombre",
                ])->execute();

                $idmedi = Yii::$app->db->getLastInsertID();

                $detalle_medi = Yii::$app->db->createCommand()->insert('detalle_medi', [
                    'idmedi'                  => $idmedi,
                    'idtipo'                  => $presentacion,
                ])->execute();
                /* FIN REGISTRAR MEDICAMENTO */

                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                if($medicamento && $detalle_medi)
                {
                    return [
                        'data' => [
                            'success' => true,
                            'message' => 'Medicamento Registrado Exitosamente.',
                        ],
                        'code' => 1,
                    ];
                }
                else
                {
                    return [
                        'data' => [
                            'success' => false,
                            'message' => 'Ocurrió un error al registrar el medicamento.',
                    ],
                        'code' => 0, // Some semantic codes that you know them for yourself
                    ];
                }
            }

            /* VALIDACIÓN */


        }

    }

    public function actionQueryupdate()
    {

        $id_detalle_medi = $_POST['id_detalle_medi'];

        if (Yii::$app->request->isAjax) 
        {
           
            $detalle_medi = 
            Yii::$app->db->createCommand("SELECT
            detalle_medi.id_detalle_medi,
            medicamentos.idmedi,
            medicamentos.nombre, 
            tipo_medicamento.descripcion
            from detalle_medi as detalle_medi
            join medicamentos as medicamentos
            on medicamentos.idmedi=detalle_medi.idmedi
            join tipo_medicamento as tipo_medicamento
            on detalle_medi.idtipo=tipo_medicamento.idtipo
            WHERE id_detalle_medi=$id_detalle_medi")->queryAll();

            foreach ($detalle_medi as $detalle_medi) {
                $idmedi             = $detalle_medi['idmedi'];
                $id_detalle_medi    = $detalle_medi['id_detalle_medi'];
                $nombre             = $detalle_medi['nombre'];
                $descripcion        = $detalle_medi['descripcion'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($detalle_medi)
            {
                return [
                    'data' => [
                        'success'           => true,
                        'message'           => 'Consulta Exitosa',
                        'idmedi'            => $idmedi,
                        'id_detalle_medi'   => $id_detalle_medi,
                        'descripcion'       => $descripcion,
                        'nombre'            => $nombre, 
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
     * Updates an existing Medicamentos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idmedi Idmedi
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {

        if (Yii::$app->request->isAjax) 
        {
            $idmedi                        = $_POST['idmedi'];
            $id_detalle_medi               = $_POST['id_detalle_medi'];
            $nombre_update                 = $_POST['nombre_update'];
            $presentacion_update           = $_POST['presentacion_update'];

            /* ACTUALIZAR MEDICAMENTO */
            $update_medicamento = Yii::$app->db->createCommand("UPDATE public.medicamentos
            SET nombre='$nombre_update'
            WHERE idmedi=$idmedi")->queryAll();

            $update_detalle_medi = Yii::$app->db->createCommand("UPDATE public.detalle_medi
            SET idmedi=$idmedi, idtipo=$presentacion_update
            WHERE id_detalle_medi=$id_detalle_medi")->queryAll();
            /* FIN ACTUALIZAR MEDICAMENTO */


            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($update_medicamento && $update_detalle_medi)
            {
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Medicamento Modificado Exitosamente',
                    ],
                    'code' => 1,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error al modificar el medicamento',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
        }
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
