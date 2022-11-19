<?php

namespace app\controllers;

use Yii;
use app\models\Entradasmedicamentos;
use app\models\EntradasmedicamentosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

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
        medicamentos.nombre, tipo_medicamento.descripcion, detalle_entra.fecha_entrada,
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
		on detalle_medi.idtipo=tipo_medicamento.idtipo")->queryAll();

        return $this->render('index', [
            'searchModel'               => $searchModel,
            'dataProvider'              => $dataProvider,
            'entradas_medicamentos'     => $entradas_medicamentos,
            'model'                     => $model,
        ]);
    }

    /**
     * Displays a single Entradasmedicamentos model.
     * @param int $identrada Identrada
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($identrada)
    {
        return $this->render('view', [
            'model' => $this->findModel($identrada),
        ]);
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
            }

            if($consulta_almacen)
            {
                $suma = $unidades + $cantidad;

                $update_almacen = 
                Yii::$app->db->createCommand("UPDATE public.almacen_general
                SET cantidad=$suma
                WHERE idal_gral=$idmedi")->queryAll();
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

    /**
     * Updates an existing Entradasmedicamentos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $identrada Identrada
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($identrada)
    {
        $model = $this->findModel($identrada);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'identrada' => $model->identrada]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
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
