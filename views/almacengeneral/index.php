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

    //Modal Modificar Registro Inventario
    //-----------------------------------
    function updateIn(id)
    {
            event.preventDefault();

            document.querySelector(".preloader").style.display = '';

            let data_idal_gral = id;

            $('#actualizarInventario').modal({ show:true });
          
            var url = "http://sidmed.ve/index.php?r=almacengeneral/queryupdate";
    
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
                    
                    document.getElementById("cantidad-update").setAttribute("value", response.data.cantidad);
                    document.getElementById("idal_gral_update").setAttribute("value", response.data.idal_gral);
                    
                    
                    //document.getElementById("viewPedidoLabel").innerHTML = response.data.nombre+ " " + response.data.presentacion;
                }
            })
            .fail(function() {
                console.log("error");
            });
    }
    //Fin Modificar Registro inventario
    //---------------------------------
</script>


<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="container-fluid">
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
                                <a onclick="updateIn(<?= $almacen_general['idal_gral']; ?>)" href="" class="btn btn-primary btn-sm">
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

<?= $this->render('modal_update_inventario', [
        'model' => $model,
]) ?>

<?= $this->render('../site/preloader') ?>


<?php
$script = <<< JS


    validateNumberBlur("cantidad-update");


   //Actualizar Pedido de Medicamento
   //--------------------------------
   $("#modificar_inventario").click(function(event) {

        document.querySelector(".preloader").setAttribute("style", "");
        event.preventDefault(); 

        var idal_gral_update      = document.getElementById("idal_gral_update").value;
        var cantidad_update       = document.getElementById("cantidad-update").value;

        var url = "http://sidmed.ve/index.php?r=almacengeneral/update";

        //Verificar validacion
        //---------------------
        var VerficarValidacion = 
        [
            validateNumber("cantidad-update"),
        ];

        for (ver = 0; ver < VerficarValidacion.length; ver++) {
            if(VerficarValidacion[ver] === false)
            {
                document.querySelector(".preloader").style.display = 'none';
                event.preventDefault();  //stopping submitting
                Swal.fire(
                'Error',
                'Verifica que los campos tengan los valores correspondientes.',
                'warning'
                );
                console.log(VerficarValidacion[ver]);
                return false;
            }
            else
            {

            }
        }
        //Fin verificar validación
        //------------------------

        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: {
                        cantidad_update  : cantidad_update,
                        idal_gral_update : idal_gral_update 
            }
        })
        .done(function(response) {

            if (response.data.success == true) 
            {    
                document.querySelector(".preloader").style.display = 'none';
                Swal.fire(
                response.data.message,
                '',
                'success'
                );
            }
            else
            {
                document.querySelector(".preloader").style.display = 'none';
                Swal.fire(
                response.data.message,
                '',
                'error'
                )
            }
        
            })
            .fail(function() {
            console.log("error");
            });
        });


//Fin Actualizar Pedido de Medicamento
//------------------------------------

   //Fin Actualizar Pedido de Medicamento
   //------------------------------------


   //Filtrar canidad de medicamentos disponibles
   //-------------------------------------------
   $("#pedido-idmedi").change(function(event) {

        let unidad = document.getElementById("pedido-idmedi").value;
        let cantidad_de_unidades = document.getElementById("cantidad_de_unidades");
        var url = "http://sidmed.ve/index.php?r=distribucion/filtrounidades";
    
        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: {
                    unidad : unidad
            }
        })
        .done(function(response) {
            if (response.data.success == true) 
            {
                document.querySelector(".preloader").style.display = 'none';
                cantidad_de_unidades.innerHTML = 'Disponible: '+response.data.unidades+' Unidades';
                cantidad_de_unidades.style.backgroundColor = "#1cc88a";
                cantidad_de_unidades.style.border = "solid 1px #1cc88a";
                cantidad_de_unidades.style.color = "#fff";
            }
        })
        .fail(function() {
            console.log("error");
        });
    });

    $("#pedido-idmedi-update").change(function(event) {

        let unidad = document.getElementById("pedido-idmedi-update").value;
        let cantidad_de_unidades = document.getElementById("cantidad_de_unidades_update");
        var url = "http://sidmed.ve/index.php?r=distribucion/filtrounidades";

        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: {
                    unidad : unidad
            }
        })
        .done(function(response) {
            if (response.data.success == true) 
            {
                document.querySelector(".preloader").style.display = 'none';
                cantidad_de_unidades.innerHTML = 'Disponible: '+response.data.unidades+' Unidades';
                cantidad_de_unidades.style.backgroundColor = "#1cc88a";
                cantidad_de_unidades.style.border = "solid 1px #1cc88a";
                cantidad_de_unidades.style.color = "#fff";
            }
        })
        .fail(function() {
            console.log("error");
        });
    });
    //Filtrar canidad de medicamentos disponibles
   //-------------------------------------------

JS;
$this->registerJs($script);
?>
