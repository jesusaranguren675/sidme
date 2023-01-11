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

<script>
    //Modal ver Registro Inventario
    //----------------
    function view(id) 
    {
            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_idal_gral = id;

            $('#viewInventario').modal({ show:true });

            var url = "http://sidmed.ve/index.php?r=almacengeneral/view";
    
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                    data_idal_gral : data_idal_gral
                }
            })
            .done(function(response) {
                if (response.data.success == true) 
                {
                    document.querySelector(".preloader").style.display = 'none';
                    
                    
                    document.getElementById("data_1").innerHTML = response.data.idal_gral;
                    document.getElementById("data_2").innerHTML = response.data.nombre;
                    document.getElementById("data_3").innerHTML = response.data.presentacion;
                    document.getElementById("data_4").innerHTML = response.data.cantidad;


                    document.getElementById("viewInventarioLabel").innerHTML = response.data.nombre+ " " + response.data.presentacion;

                    
                }

            })
            .fail(function() {
                console.log("error");
            });
    //Fin Modal ver Registro Inventario
    //---------------------------------
    }
</script>


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="container">
    <h1 class="h3 mb-2 text-gray-800" style="margin-top: 20px;"><?= Html::encode($this->title) ?></h1>
    <hr>

    <a class="btn btn-primary btn-sm"  href="<?= Url::toRoute('entradasmedicamentos/index'); ?>">
        Agregar 
        <i class="fas fa-plus"></i>
    </a>
    <a class="btn btn-danger btn-sm" href="<?= $url = Url::to(['almacengeneral/report']) ?>" target="_blank">
        PDF <i class="far fa-file-pdf"></i>
    </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Presentación</th>
                        <th style="text-align: center;">Unidades</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($almacen_general as $almacen_general): ?>
                        <tr>
                            <td><?= $almacen_general['idal_gral'] ?></td>
                            <td><?= $almacen_general['nombre'] ?></td>
                            <td><?= $almacen_general['descripcion'] ?></td>
                            <td style="text-align: center;">
                                <button class="btn btn-success btn-sm">
                                <?= $almacen_general['cantidad'] ?>
                                </button>
                            </td>
                            <td style="text-align: center;">
                                <a onclick="view(<?= $almacen_general['idal_gral']; ?>)" href="#" class="btn btn-primary btn-sm">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a href="" class="btn btn-primary btn-sm">
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

<?= $this->render('modal_view_inventario', [
        'model' => $model,
]) ?>

<?= $this->render('../site/preloader') ?>