<?php

namespace app\controllers;

use Yii;
use app\models\Usuario;
use app\models\user;
use app\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Mpdf\Mpdf;

/**
 * UserController implements the CRUD actions for Usuario model.
 */
class UserController extends Controller
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
     * Lists all Usuario models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $model = new Usuario();

        $usuarios = 
        Yii::$app->db->createCommand("SELECT usuario.id, usuario.username, 
        usuario.email, rol.nombre_rol,
        usuario.status AS estatus, asignacion.fecha FROM public.user AS usuario
        JOIN asignacion_roles AS asignacion
        ON asignacion.id_usu=usuario.id
        JOIN roles AS rol
        ON rol.id_rol=asignacion.id_rol")->queryAll();


        return $this->render('index', [
            'searchModel'           => $searchModel,
            'dataProvider'          => $dataProvider,
            'usuarios'              => $usuarios,
            'model'                 => $model,
        ]);
    }

    /**
     * Displays a single Usuario model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView()
    {

        $data_id = $_POST['data_id'];

        if (Yii::$app->request->isAjax) 
        {
           
            $usuarios_consul = 
            Yii::$app->db->createCommand("SELECT usuario.id, usuario.username, 
            usuario.email, rol.nombre_rol,
            usuario.status AS estatus, asignacion.fecha FROM public.user AS usuario
            JOIN asignacion_roles AS asignacion
            ON asignacion.id_usu=usuario.id
            JOIN roles AS rol
            ON rol.id_rol=asignacion.id_rol
            WHERE usuario.id=$data_id")->queryAll();

            foreach ($usuarios_consul as $usuarios) {
                $id             = $usuarios['id'];
                $username       = $usuarios['username'];
                $email          = $usuarios['email'];
                $nombre_rol     = $usuarios['nombre_rol'];
                $estatus        = $usuarios['estatus'];
                $fecha          = $usuarios['fecha'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($usuarios_consul)
            {
                return [
                    'data' => [
                        'success'           => true,
                        'message'           => 'Consulta Exitosa',
                        'id'                => $id,
                        'username'          => $username,
                        'email'             => $email, 
                        'nombre_rol'        => $nombre_rol,
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

    public function actionReport() {

        $usuarios = 
            Yii::$app->db->createCommand("SELECT usuario.id, usuario.username, 
            usuario.email, rol.nombre_rol,
            usuario.status AS estatus, asignacion.fecha FROM public.user AS usuario
            JOIN asignacion_roles AS asignacion
            ON asignacion.id_usu=usuario.id
            JOIN roles AS rol
            ON rol.id_rol=asignacion.id_rol")->queryAll();
        
            $mpdf = new mPDF();
            //$mpdf->SetHeader(Html::img('@web/img/cintillo_pdf.jpg')); 
            $mpdf->setFooter('{PAGENO}'); 
            $mpdf->WriteHTML($this->renderPartial('_reportView', ['usuarios' => $usuarios]));
            $mpdf->Output();
            exit;
    }

    public function actionQueryupdate()
    {


        $data_id = $_POST['data_id'];

        if (Yii::$app->request->isAjax) 
        {
           
            $usuarios_consul = 
            Yii::$app->db->createCommand("SELECT usuario.id, usuario.username, 
            usuario.email, rol.nombre_rol,
            usuario.status AS estatus, asignacion.fecha FROM public.user AS usuario
            JOIN asignacion_roles AS asignacion
            ON asignacion.id_usu=usuario.id
            JOIN roles AS rol
            ON rol.id_rol=asignacion.id_rol
            WHERE usuario.id=$data_id")->queryAll();

            foreach ($usuarios_consul as $usuarios) {
                $id             = $usuarios['id'];
                $username       = $usuarios['username'];
                $email          = $usuarios['email'];
                $nombre_rol     = $usuarios['nombre_rol'];
                $estatus        = $usuarios['estatus'];
                $fecha          = $usuarios['fecha'];
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($usuarios_consul)
            {
                return [
                    'data' => [
                        'success'           => true,
                        'message'           => 'Consulta Exitosa',
                        'id'                => $id,
                        'username'          => $username,
                        'email'             => $email, 
                        'nombre_rol'        => $nombre_rol,
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


    /**
     * Creates a new Usuario model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Usuario();

        if (Yii::$app->request->isAjax) 
        {
            $username              = $_POST['username'];
            $password_hash         = $_POST['password_hash'];
            $email                 = $_POST['email'];
            $status                = $_POST['status'];
            $rol                   = $_POST['rol'];
            $fecha                 = date('d/m/y');

            $hash = Yii::$app->getSecurity()->generatePasswordHash($password_hash);

            $consulta_usuario = 
            Yii::$app->db->createCommand("SELECT * 
            FROM public.user WHERE email='$email' OR username='$username'")->queryAll();

            if($consulta_usuario)
            {
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                return [
                    'data' => [
                        'success' => false,
                        'message' => 'El Usuario Se Encuentra Registrado.',
                    ],
                    'code' => 0,
                ];

            }
            else
            {
                $ingresar_usuario = Yii::$app->db->createCommand()->insert('public.user', [
                    'username'                  => $username,
                    'password_hash'             => $hash,
                    'email'                     => $email,
                    'status'                    => $status,
                ])->execute();
    
                $idusu = Yii::$app->db->getLastInsertID();
    
                $asignacion_roles = Yii::$app->db->createCommand()->insert('asignacion_roles', [
                    'id_rol'                  => $rol,
                    'id_usu'                  => $idusu,
                    'fecha'                   => $fecha,
                ])->execute();
            }

        
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($asignacion_roles)
            {
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Usuario Registrado Exitosamente',
                    ],
                    'code' => 1,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error al registrar el usuario',
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
     * Updates an existing Usuario model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate()
    {
        if (Yii::$app->request->isAjax) 
        {
            $id                    = $_POST['id'];
            $username              = $_POST['username'];
            $password_hash         = $_POST['password_hash'];
            $email                 = $_POST['email'];
            $status                = $_POST['status'];
            $rol                   = $_POST['rol'];
            /* ACTUALIZAR ENTRADA DE MEDICAMENTO */
            $update_usuario = Yii::$app->db->createCommand("UPDATE public.user
            SET username='$username', password_hash='$password_hash', email='$email', status=$status
            WHERE id=$id")->queryAll();

            $update_rol = Yii::$app->db->createCommand("UPDATE public.asignacion_roles
            SET id_rol=$rol
            WHERE id_rol=$rol")->queryAll();

            /* FIN ACTUALIZAR ENTRADA DE MEDICAMENTO */


            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($update_usuario && $update_rol)
            {
                return [
                    'data' => [
                        'success' => true,
                        'message' => 'Usuario Modificado Exitosamente',
                    ],
                    'code' => 1,
                ];
            }
            else
            {
                return [
                    'data' => [
                        'success' => false,
                        'message' => 'Ocurrió un error al modificar el usuario',
                ],
                    'code' => 0, // Some semantic codes that you know them for yourself
                ];
            }
        }
    }

    /**
     * Deletes an existing Usuario model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Usuario model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Usuario the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Usuario::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
