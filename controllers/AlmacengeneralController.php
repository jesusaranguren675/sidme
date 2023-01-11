<?php

namespace app\controllers;
use Yii;
use app\models\Almacengeneral;
use app\models\AlmacengeneralSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;

/**
 * AlmacengeneralController implements the CRUD actions for Almacengeneral model.
 */
class AlmacengeneralController extends Controller
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
     * Lists all Almacengeneral models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new AlmacengeneralSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $model = new Almacengeneral();

        $almacen_general = 
        Yii::$app->db->createCommand("select almacen_general.idal_gral,
        almacen_general.cantidad, medicamentos.nombre, tipo_medicamento.descripcion
        from almacen_general join detalle_medi as detalle_medi
        on almacen_general.idmedi=detalle_medi.id_detalle_medi
        join medicamentos as medicamentos
        on medicamentos.idmedi=detalle_medi.idmedi
        join tipo_medicamento as tipo_medicamento
        on tipo_medicamento.idtipo=detalle_medi.idtipo")->queryAll();

        return $this->render('index', [
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
            'almacen_general'       => $almacen_general,
            'model'                 => $model,
        ]);
    }

    public function actionReport() {

        $almacen_general = 
            Yii::$app->db->createCommand("SELECT almacen_general.idal_gral,
            medicamentos.nombre, tipo_medicamento.descripcion as presentacion, almacen_general.cantidad
            from almacen_general join detalle_medi as detalle_medi
            on almacen_general.idmedi=detalle_medi.id_detalle_medi
            join medicamentos as medicamentos
            on medicamentos.idmedi=detalle_medi.idmedi
            join tipo_medicamento as tipo_medicamento
            on tipo_medicamento.idtipo=detalle_medi.idtipo")->queryAll();
        
            $mpdf = new mPDF();
            //$mpdf->SetHeader(Html::img('@web/img/cintillo_pdf.jpg')); 
            $mpdf->setFooter('{PAGENO}'); 
            $mpdf->WriteHTML($this->renderPartial('_reportView', ['almacen_general' => $almacen_general]));
            $mpdf->Output();
            exit;
    }

    /**
     * Displays a single Almacengeneral model.
     * @param int $idal_gral Idal Gral
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $data_idal_gral = $_POST['data_idal_gral'];

        if (Yii::$app->request->isAjax) 
        {
           
            $almacen_general_consul = 
            Yii::$app->db->createCommand("SELECT almacen_general.idal_gral,
            medicamentos.nombre, tipo_medicamento.descripcion as presentacion, almacen_general.cantidad
            from almacen_general join detalle_medi as detalle_medi
            on almacen_general.idmedi=detalle_medi.id_detalle_medi
            join medicamentos as medicamentos
            on medicamentos.idmedi=detalle_medi.idmedi
            join tipo_medicamento as tipo_medicamento
            on tipo_medicamento.idtipo=detalle_medi.idtipo
            WHERE almacen_general.idal_gral=$data_idal_gral")->queryAll();

            foreach ($almacen_general_consul as $almacen_general) {
                $idal_gral      = $almacen_general['idal_gral'];
                $nombre         = $almacen_general['nombre'];
                $presentacion   = $almacen_general['presentacion'];
                $cantidad       = $almacen_general['cantidad'];

            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($almacen_general_consul)
            {
                return [
                    'data' => [
                        'success'           => true,
                        'message'           => 'Consulta Exitosa',
                        'idal_gral'         => $idal_gral,
                        'nombre'            => $nombre, 
                        'presentacion'      => $presentacion,
                        'cantidad'          => $cantidad,
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
     * Creates a new Almacengeneral model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */

     public function actionQueryupdate()
     {

         $idal_gral = $_POST['data_idal_gral'];
 
         if (Yii::$app->request->isAjax) 
         {
            
             $almacen_general_consul = 
             Yii::$app->db->createCommand("SELECT almacen_general.idal_gral,
             medicamentos.nombre, tipo_medicamento.descripcion as presentacion, almacen_general.cantidad
             from almacen_general join detalle_medi as detalle_medi
             on almacen_general.idmedi=detalle_medi.id_detalle_medi
             join medicamentos as medicamentos
             on medicamentos.idmedi=detalle_medi.idmedi
             join tipo_medicamento as tipo_medicamento
             on tipo_medicamento.idtipo=detalle_medi.idtipo
             WHERE almacen_general.idal_gral=$idal_gral")->queryAll();
 
             foreach ($almacen_general_consul as $almacen_general) {
                 $idal_gral         = $almacen_general['idal_gral'];
                 $nombre            = $almacen_general['nombre'];
                 $presentacion      = $almacen_general['presentacion'];
                 $cantidad          = $almacen_general['cantidad'];
             }
 
             Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
 
             if($almacen_general_consul)
             {
                 return [
                     'data' => [
                         'success'           => true,
                         'message'           => 'Consulta Exitosa',
                         'idal_gral'         => $idal_gral,
                         'nombre'            => $nombre, 
                         'presentacion'      => $presentacion,
                         'cantidad'          => $cantidad,  
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

    public function actionCreate()
    {
        $model = new Almacengeneral();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'idal_gral' => $model->idal_gral]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Almacengeneral model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $idal_gral Idal Gral
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        $idal_gral_update   = $_POST['idal_gral_update'];
        $cantidad_update    = $_POST['cantidad_update'];

        if (Yii::$app->request->isAjax) 
        {
           
            $almacen_general_update = 
            Yii::$app->db->createCommand("UPDATE public.almacen_general
            SET cantidad=$cantidad_update
            WHERE idal_gral=$idal_gral_update")->queryAll();

        
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($almacen_general_update)
            {
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Inventario Modificada Exitosamente',
                    ],
                    'code' => 1,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error al modificar el Inventario',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
        }
    }


    /**
     * Deletes an existing Almacengeneral model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $idal_gral Idal Gral
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($idal_gral)
    {
        $this->findModel($idal_gral)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Almacengeneral model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $idal_gral Idal Gral
     * @return Almacengeneral the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($idal_gral)
    {
        if (($model = Almacengeneral::findOne(['idal_gral' => $idal_gral])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
