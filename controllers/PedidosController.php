<?php

namespace app\controllers;

use Yii;
use app\models\Pedidos;
use app\models\PedidosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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

        $pedidos = 
        Yii::$app->db->createCommand("SELECT pedidos.idpedi, 
        pedidos.descripcion,
        medicamentos.nombre,
        tipo_medicamento.descripcion AS presentacion,
        detalle_pedi.cantidad,
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
        ]);
    }

    /**
     * Displays a single Pedidos model.
     * @param int $idpedi Idpedi
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($idpedi)
    {
        return $this->render('view', [
            'model' => $this->findModel($idpedi),
        ]);
    }

    /**
     * Creates a new Pedidos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Pedidos();

        var_dump($_POST); die(); 

        if (Yii::$app->request->isAjax) 
        {
            $pedido_idmedi          = $_POST['pedido_idmedi'];
            $pedido_descripcion     = $_POST['pedido_descripcion'];
            $pedido_idsede          = $_POST['pedido_idsede'];
            $pedido_cantidad        = $_POST['pedido_cantidad'];
            $idusu                  = Yii::$app->user->identity->id;
            $fecha                  = date('d/m/y');

            /* REGISTRAR PEDIDO */
            $pedido = Yii::$app->db->createCommand()->insert('pedidos', [
                'descripcion'                  => $pedido_descripcion,
                'idusu'                        => $idusu,
            ])->execute();

            $idpedi = Yii::$app->db->getLastInsertID();

            $detalle_pedi = 
            Yii::$app->db->createCommand("INSERT INTO public.detalle_dis(
                idpedi, idmedi, procedencia, cantidad, fecha)
                VALUES ($idpedi, $pedido_idmedi, $pedido_idsede , $pedido_cantidad, '$fecha');")->queryAll();
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
    public function actionUpdate($idpedi)
    {
        $model = $this->findModel($idpedi);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'idpedi' => $model->idpedi]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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
