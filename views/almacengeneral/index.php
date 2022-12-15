<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlmacengeneralSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Inventario';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>


<!-- Page Heading -->


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="container">
    <h1 class="h3 mb-2 text-gray-800" style="margin-top: 20px;"><?= Html::encode($this->title) ?></h1>
    <hr>

    <a class="btn btn-primary btn-sm">Agregar <i class="fas fa-plus"></i></a>
    <a class="btn btn-danger btn-sm">PDF<i class="far fa-file-pdf"></i></a>
    <a class="btn btn-success btn-sm">EXCEL<i class="far fa-file-excel"></i></a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th style="text-align: center;">Unidades</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th style="text-align: center;">Unidades</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($almacen_general as $almacen_general): ?>
                        <tr>
                            <td><?= $almacen_general['idal_gral'] ?></td>
                            <td><?= $almacen_general['nombre'] ?></td>
                            <td><?= $almacen_general['descripcion'] ?></td>
                            <td style="text-align: center;">
                                <button class="btn btn-success btn-circle btn-sm">
                                <?= $almacen_general['cantidad'] ?>
                                </button>
                            </td>
                            <td style="text-align: center;">
                                <a href="<?= Url::to(['almacengeneral/view', 'idal_gral' => $almacen_general['idal_gral']]); ?>" class="btn btn-primary btn-sm">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a href="<?= Url::to(['almacengeneral/update', 'idal_gral' => $almacen_general['idal_gral']]); ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

