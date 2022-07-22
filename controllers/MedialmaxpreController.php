<?php


namespace app\controllers;

use Yii;

use app\models\Medialmaxpre;
use app\models\MedialmaxpreSearch;
use app\models\Procedencias;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MedialmaxpreController implements the CRUD actions for Medialmaxpre model.
 */
class MedialmaxpreController extends Controller
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
     * Lists all Medialmaxpre models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new MedialmaxpreSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        $model = new Medialmaxpre();

        $almacen = 
        Yii::$app->db->createCommand("
        SELECT almacen.id_medi_alma_x_pre, MA.nombre_medicamento_almacen, PRE.nombre_presentacion, 
        ME.cantidad AS entrada, MS.cantidad AS salida, stock AS existencia
        FROM public.medi_alma_x_pre AS almacen
        LEFT JOIN medicamentos_almacen AS MA
        ON MA.id_medicamento_almacen=almacen.id_medicamento_almacen
        LEFT JOIN presentaciones AS PRE
        ON almacen.id_presentacion=PRE.id_presentacion
        LEFT JOIN entradas_medicamentos AS ME
        ON almacen.id_presentacion=ME.id_presentacion
        AND almacen.id_medicamento_almacen=Me.id_medicamento_almacen
        LEFT JOIN salidas_medicamentos AS MS
        ON almacen.id_presentacion=MS.id_presentacion
        AND almacen.id_medicamento_almacen=MS.id_medicamento_almacen")->queryAll();



        return $this->render('index', [
            'searchModel'       => $searchModel,
            'almacen'           => $almacen,
            'model'             => $model,
            'dataProvider'      => $dataProvider,
        ]);
    }

    /**
     * Displays a single Medialmaxpre model.
     * @param int $id_medi_alma_x_pre Id Medi Alma X Pre
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_medi_alma_x_pre)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_medi_alma_x_pre),
        ]);
    }

    /**
     * Creates a new Medialmaxpre model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Medialmaxpre();

        if (Yii::$app->request->isAjax) 
        {
            /*1) Recuperamos los datos enviados por el metodo post */
            $nombre_medicamento_almacen         = strtolower($_POST['nombre_medicamento_almacen']);
            $medialmaxpre_id_presentacion       = intval($_POST['medialmaxpre_id_presentacion']);
            $medialmaxpre_id_procedencia        = $_POST['medialmaxpre_id_procedencia'];
            $medialmaxpre_stock                 = $_POST['medialmaxpre_stock'];
            $id_usuario                         = Yii::$app->user->identity->id;
 
            
            /* LLevamos a cabo una validación */
            //var_dump($nombre_medicamento_almacen); die();

            /* 2) Consultamos el medicamento en la bd */
            $medicamento = 
            Yii::$app->db->createCommand("SELECT * FROM medicamentos_almacen AS ma
            WHERE ma.nombre_medicamento_almacen='$nombre_medicamento_almacen'")->queryAll();

            foreach ($medicamento as $medicamento) {
                $id_medicamento_almacen     = intval($medicamento['id_medicamento_almacen']);
                $nombre_medicamento_almacen = $medicamento['nombre_medicamento_almacen'];
            }

            //var_dump($medicamento); die();

            /* 3) En caso de que el medicamento exista en la bd
            consultamos la tabla intermedia, si el medicamento existe
            entonces informamos al usuario que el medicamento existe en la bd*/
            if($medicamento)
            {
                
                $medicamento_tbl_intermedia = (new yii\db\Query())
                ->select('id_medicamento_almacen,
                        id_presentacion,
                        stock'
                    )
                ->from('medi_alma_x_pre')
                ->where(['id_medicamento_almacen' => $id_medicamento_almacen])
                ->andWhere('id_presentacion=:id_presentacion')
                ->addParams([':id_presentacion' => $medialmaxpre_id_presentacion]) 
                ->all();

                if(!empty($medicamento_tbl_intermedia))
                {
                    Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                        return [
                            'data' => [
                                'validation'                 => true,
                                'message'                    => 'El Medicamento Ya Esta Registrado',
                                'medicamento_alamacen'       => $nombre_medicamento_almacen,
                            ],
                            'code' => 1, // Some semantic codes that you know them for yourself
                        ];

                }
                else{ /*4)En caso de que el medicamento no exista en la tbl intermedia */

                    /* Verificamos que el medicamento que existe en tbl medicamentos
                    almacen tenga una presentación distinta a la que ya existe */
                    $medicamento_tbl_intermedia = (new yii\db\Query())
                    ->select('id_medicamento_almacen,
                            id_presentacion,
                            stock'
                        )
                    ->from('medi_alma_x_pre')
                    ->where(['id_medicamento_almacen' => $id_medicamento_almacen])
                    ->andWhere('id_presentacion<>:id_presentacion')
                    ->addParams([':id_presentacion' => $medialmaxpre_id_presentacion]) 
                    ->all();

                    /* Si la consulta esta vacía debido a que no existe un medicamento
                    con la misma presentación entonces procedemos a insertar el medicamento
                    en la tabla intermedia pero con una presentación diferente */
                    if(!empty($medicamento_tbl_intermedia))
                    {
                        /* consultamos el id del medicamento existente */
                        $me = (new yii\db\Query())
                        ->select('id_medicamento_almacen')
                        ->from('medicamentos_almacen')
                        ->where(['id_medicamento_almacen' => $id_medicamento_almacen])
                        ->all();
    
                        foreach ($me as $me)
                        {
                            $id_medicamento_almacen = $me['id_medicamento_almacen'];
                        }
    
                        /* Para luego insertar el medicamento en tbl intermedia
                        e informar al usuario de que el medicamento se registro de forma
                        exitosa y en la tabla entradas medicamentos*/
                        $medicamento_almacen = Yii::$app->db->createCommand()->insert('medi_alma_x_pre', [
                            'id_medicamento_almacen'        => $id_medicamento_almacen,
                            'id_presentacion'               => $medialmaxpre_id_presentacion,
                            'stock'                         => $medialmaxpre_stock,
                        ])->execute();

                        //Insertamos el medicamento en la tabla entradas_medicamentos
                        $entrada_medicamento = Yii::$app->db->createCommand()->insert('entradas_medicamentos', [
                            'id_medicamento_almacen'            => $id_medicamento_almacen,
                            'id_presentacion'                   => $medialmaxpre_id_presentacion,
                            'id_procedencia'                    => $medialmaxpre_id_procedencia,
                            'cantidad'                          => $medialmaxpre_stock,
                            'id_usuario'                        => $id_usuario,
                            'fecha_entrada'                     => '11/12/1999',
                        ])->execute();
    
                        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
                        if($medicamento_almacen)
                        {
                            return [
                                'data' => [
                                    'success' => true,
                                    'message' => 'Medicamento Registrado Exitosamente',
                                    'id'      => $id_medicamento_almacen,
                                ],
                                'code' => 1, // Some semantic codes that you know them for yourself
                            ];
                        } 
                    }


                }
            }
            else /* 5) En caso de que la consulta realizada en el segundo punto
            no sea verdadera, procedemos a insertar el medicamento en la tabla medicamento_almacen,
            tabla intermedia y medicamentos entradas */
            {
                //Insertar Medicamento en la Tabla Medicamentos Almacen
                $medicamento_almacen = Yii::$app->db->createCommand()->insert('medicamentos_almacen', [
                    'nombre_medicamento_almacen'        => $nombre_medicamento_almacen,
                ])->execute();
                //Recuperamos el id del medicamento agregado
                $id_medicamento_almacen = Yii::$app->db->getLastInsertID();
    
                //Insertamos en la tabla intermedia el medicamento debido a la relación
                //Muchos a muchos
                $medialmaxpre = Yii::$app->db->createCommand()->insert('medi_alma_x_pre', [
                    'id_medicamento_almacen'            => $id_medicamento_almacen,
                    'id_presentacion'                   => $medialmaxpre_id_presentacion,
                    'stock'                             => $medialmaxpre_stock,
                ])->execute();
    
                //Insertamos el medicamento en la tabla entradas_medicamentos
                $entrada_medicamento = Yii::$app->db->createCommand()->insert('entradas_medicamentos', [
                    'id_medicamento_almacen'            => $id_medicamento_almacen,
                    'id_presentacion'                   => $medialmaxpre_id_presentacion,
                    'id_procedencia'                    => $medialmaxpre_id_procedencia,
                    'cantidad'                          => $medialmaxpre_stock,
                    'id_usuario'                        => $id_usuario,
                    'fecha_entrada'                     => '11/12/1999',
                ])->execute();
    
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
                if($medialmaxpre)
                {
                    return [
                        'data' => [
                            'success' => true,
                            'message' => 'Medicamento Registrado Exitosamente',
                            'id'      => $id_medicamento_almacen,
                        ],
                        'code' => 1, // Some semantic codes that you know them for yourself
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


        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Medialmaxpre model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id_medi_alma_x_pre Id Medi Alma X Pre
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_medi_alma_x_pre)
    {
        $model = $this->findModel($id_medi_alma_x_pre);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_medi_alma_x_pre' => $model->id_medi_alma_x_pre]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Medialmaxpre model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id_medi_alma_x_pre Id Medi Alma X Pre
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_medi_alma_x_pre)
    {
        $this->findModel($id_medi_alma_x_pre)->delete();

        return $this->redirect(['index']);
    }

    public function actionFiltroprocedencia()
    {

        if (Yii::$app->request->isAjax) 
        {
            $parametro = intval($_POST['tipo_procedencia']);

            $procedencia = Yii::$app->db->createCommand("
            SELECT * FROM procedencias AS procedencia
            JOIN tipos_procedencia AS tipo_procedencia
            ON procedencia.id_tipo_procedencia=tipo_procedencia.id_tipo_procedencia
            WHERE tipo_procedencia.id_tipo_procedencia=$parametro")
            ->queryAll();

        
            //var_dump($comunidades); die();
            // Se itera sobre el arreglo y se definen las variables a enviar por ajax

            if(empty($procedencia))
            {
                $procedencia = false;
            }

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if($_POST != "")
            {
                return [
                    'data' => [
                        'success'                   => true,
                        'message'                   => 'Consulta exitosa.',
                        'procedencia'               => $procedencia,
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

    /**
     * Finds the Medialmaxpre model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id_medi_alma_x_pre Id Medi Alma X Pre
     * @return Medialmaxpre the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_medi_alma_x_pre)
    {
        if (($model = Medialmaxpre::findOne(['id_medi_alma_x_pre' => $id_medi_alma_x_pre])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
