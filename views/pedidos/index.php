<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PedidosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pedidos';
$this->params['breadcrumbs'][] = $this->title;
?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800" style="margin-top: 20px;"><?= Html::encode($this->title) ?></h1>
        <hr>
        <a class="btn btn-danger btn-sm">pdf <i class="far fa-file-pdf"></i></a>
        <a class="btn btn-success btn-sm">excel <i class="far fa-file-excel"></i></a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Descripción</th>
                        <th>Nombre</th>
                        <th>Presentación</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>N°</th>
                        <th>Descripción</th>
                        <th>Nombre</th>
                        <th>Presentación</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($pedidos as $pedidos): ?>
                        <tr>
                            <td><?= $pedidos['idpedi'] ?></td>
                            <td><?= $pedidos['descripcion'] ?></td>
                            <td width="200"><?= $pedidos['nombre'] ?></td>
                            <td><?= $pedidos['presentacion'] ?></td>
                            <td style="text-align: center;">
                                <button class="btn btn-danger btn-circle btn-sm">
                                <?= $pedidos['cantidad'] ?>
                                </button>
                            </td>
                            <td><?= $pedidos['fecha'] ?></td>
                            <td style="text-align: center;">
                                <a onclick="ver_medica(<?php echo $pedidos['idpedi']; ?>)" href="" class="btn btn-primary btn-sm">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a  href="<?= Url::to(['pedidos/update', 'idpedi' => $pedidos['idpedi']]); ?>" class="btn btn-primary btn-sm">
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
