<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\sede */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Localidad';
?>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<!-- Page Heading -->


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="container">
    <h1 class="h3 mb-2 text-gray-800" style="margin-top: 20px;"><?= Html::encode($this->title) ?></h1>
    <hr>

    <a class="btn btn-primary btn-sm">Agregar<i class="fas fa-plus"></i></a>
    <a class="btn btn-danger btn-sm">Modificar<i class="far fa-file-pdf"></i></a>
    <a class="btn btn-success btn-sm">Listar<i class="far fa-file-excel"></i></a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Ubicacion</th>
                        <th>Contacto</th>
                        <th>correo</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Unidades</th>
                        <th>Acciones</th>
                    </tr>
                </tfoot>
               
            </table>
        </div>
    </div>
</div>