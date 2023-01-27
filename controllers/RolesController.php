<?php

namespace app\controllers;

use Yii;
use app\models\Roles;
use app\models\RolesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RolesController implements the CRUD actions for Roles model.
 */
class RolesController extends Controller
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
     * Lists all Roles models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new \app\models\Roles();
        $searchModel = new RolesSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $roles = 
        Yii::$app->db->createCommand("select * from roles")->queryAll();

        return $this->render('index', [
            'searchModel'       => $searchModel,
            'dataProvider'      => $dataProvider,
            'model'             => $model,
            'roles'             => $roles,
        ]);
    }

    /**
     * Displays a single Roles model.
     * @param int $id_rol Id Rol
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {
        $data_id_rol = $_POST['data_id_rol'];

        if (Yii::$app->request->isAjax) 
        {
           
            $consulta_roles = 
            Yii::$app->db->createCommand("select * from roles where id_rol=$data_id_rol")->queryAll();

            foreach ($consulta_roles as $consulta) {
                $id_rol         = $consulta['id_rol'];
                $nombre_rol     = $consulta['nombre_rol'];
                $create_at      = $consulta['create_at'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($consulta_roles)
            {
                return [
                    'data' => [
                        'success'           => true,
                        'message'           => 'Consulta Exitosa',
                        'id_rol'            => $id_rol,
                        'nombre_rol'        => $nombre_rol,
                        'create_at'         => $create_at,   
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
     * Creates a new Roles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    /*
    public function actionCreate()
    {
        $model = new Roles();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id_rol' => $model->id_rol]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }
    */

    public function actionCreate()
    {
 
        if (Yii::$app->request->isAjax) 
        {
            
            $nombre_rol     = strtolower($_POST['nombre_rol']);
            $create_at      = date('d/m/y');

            $consulta_roles = 
            Yii::$app->db->createCommand("SELECT * 
            FROM roles WHERE nombre_rol='$nombre_rol'")->queryAll();

            foreach ($consulta_roles as $consulta_roles) {
                $consulta_nombre_rol    = $consulta_roles['nombre_rol'];
                $consulta_id_rol        = $consulta_roles['id_rol'];
            }

            if($consulta_roles)
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'El rol ya existe.',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
            else{
                
                $roles = Yii::$app->db->createCommand()->insert('roles', [
                    'nombre_rol'                  => "$nombre_rol",
                    'create_at'                   => $create_at,
                ])->execute();

                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                if($roles)
                {
                    return [
                        'data' => [
                            'success' => true,
                            'message' => 'Rol Registrado Exitosamente',
                        ],
                        'code' => 1,
                    ];
                }
                else
                {
                    return [
                        'data' => [
                            'success' => false,
                            'message' => 'Ocurrió un error al registrar el rol',
                    ],
                        'code' => 0, // Some semantic codes that you know them for yourself
                    ];
                }

            }
           
        }
    }

    public function actionQueryupdate()
    {
        
        $data_id_rol = $_POST['data_id_rol'];

        if (Yii::$app->request->isAjax) 
        {
           
            $rol = 
            Yii::$app->db->createCommand("select * from roles where id_rol=$data_id_rol")->queryAll();

            foreach ($rol as $rol) {
                $id_rol         = $rol['id_rol'];
                $nombre_rol     = $rol['nombre_rol'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($rol)
            {
                return [
                    'data' => [
                        'success'           => true,
                        'message'           => 'Consulta Exitosa',
                        'id_rol'            => $id_rol,
                        'nombre_rol'        => $nombre_rol, 
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
     * Updates an existing Roles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_rol Id Rol
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        if (Yii::$app->request->isAjax) 
        {
            $id_rol_update                  = $_POST['id_rol_update'];
            $nombre_rol_update              = $_POST['nombre_rol_update'];

            /* ACTUALIZAr roles */
            $update_rol = Yii::$app->db->createCommand("UPDATE public.roles
            SET nombre_rol='$nombre_rol_update'
            WHERE id_rol=$id_rol_update")->queryAll();

            /* FIN ACTUALIZAr roles */


            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($update_rol)
            {
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Rol Modificada Exitosamente',
                    ],
                    'code' => 1,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error al modificar el rol',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
        }
    }

    /**
     * Deletes an existing Roles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_rol Id Rol
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_rol)
    {
        $this->findModel($id_rol)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Roles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_rol Id Rol
     * @return Roles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_rol)
    {
        if (($model = Roles::findOne(['id_rol' => $id_rol])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
