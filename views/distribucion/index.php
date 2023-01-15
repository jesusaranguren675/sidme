<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DistribucionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Distribución';
$this->params['breadcrumbs'][] = $this->title;

?>

<script>
    //Modal ver Distribucion
    //----------------
    function view(id) 
    {
            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_iddis = id;

            $('#viewDistribucion').modal({ show:true });

            var url = "http://sidmed.ve/index.php?r=distribucion/view";
    
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                    data_iddis : data_iddis
                }
            })
            .done(function(response) {
                if (response.data.success == true) 
                {
                    document.querySelector(".preloader").style.display = 'none';
                    
                    document.getElementById("data_1").innerHTML = response.data.iddis;
                    document.getElementById("data_2").innerHTML = response.data.correlativo;
                    document.getElementById("data_3").innerHTML = response.data.descripcion;
                    document.getElementById("data_4").innerHTML = response.data.nombre;
                    document.getElementById("data_5").innerHTML = response.data.presentacion;
                    document.getElementById("data_6").innerHTML = response.data.destino;
                    document.getElementById("data_7").innerHTML = response.data.cantidad;
                    document.getElementById("data_8").innerHTML = response.data.fecha;
                    
                    document.getElementById("viewDistribucionLabel").innerHTML = response.data.nombre+ " " + response.data.presentacion;
                }
            })
            .fail(function() {
                console.log("error");
            });
    //Fin Modal ver Distribucion
    //--------------------
    }

    //Modal Modificar Distribucion
    //----------------------------
    function updateDis(id)
    {
            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_iddis = id;

            $('#actualizarDisttribucion').modal({ show:true });

            var url = "http://sidmed.ve/index.php?r=distribucion/queryupdate";
    
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                    data_iddis : data_iddis
                }
            })
            .done(function(response) {
                if (response.data.success == true) 
                {
                    document.querySelector(".preloader").style.display = 'none';
                    
                    document.getElementById("distribucion-descripcion-update_e").setAttribute("value", response.data.descripcion);
                    document.getElementById("distribucion-cantidad-update").setAttribute("value", response.data.cantidad);
                    document.getElementById("distribucion-iddis").setAttribute("value", response.data.iddis);
                }
            })
            .fail(function() {
                console.log("error");
            });
    }
    //Fin Modificar Modal ver Distribucion
    //------------------------------------
</script>

<style>
    .select2-selection--single {
        background-color: #fff !important;
        border: 1px solid #d1d3e2 !important;
        border-radius: 4px !important;

        
    }
    .select2-selection--single{
        height: 38px !important;
        display: flex !important;
        align-items: center !important;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #6e707e !important;
    line-height: 28px !important;
}
</style>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800" style="margin-top: 20px;"><?= Html::encode($this->title) ?></h1>
    <hr>

    <a class="btn btn-primary btn-sm" title="Agregar una Distribución"  href="<?= Url::toRoute('entradasmedicamentos/create'); ?> " data-toggle="modal" data-target="#distribuirMedicamentos">
        Agregar <i class="fas fa-plus"></i>
    </a>
   
    <a class="btn btn-danger btn-sm" title="Exportar Datos en Formato PDF" href="<?= $url = Url::to(['distribucion/report']) ?>" target="_blank">
        PDF <i class="far fa-file-pdf"></i>
    </a>

    <a class="btn btn-success btn-sm" title="Responder Pedido" href="<?= $url = Url::to(['distribucion/report']) ?>" target="_blank" data-toggle="modal" data-target="#reponderPedidos">
        PEDIDOS <i class="fas fa-table"></i>
    </a>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Entrega</th>
                        <th>Descripción</th>
                        <th>Nombre</th>
                        <th>Presentación</th>
                        <th>Destino</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($distribucion as $distribucion): ?>
                        <tr>
                            <td><?= $distribucion['iddis'] ?></td>
                            <td><?= $distribucion['correlativo'] ?></td>
                            <td><?= ucwords($distribucion['descripcion']) ?></td>
                            <td width="200"><?= $distribucion['nombre'] ?></td>
                            <td><?= $distribucion['presentacion'] ?></td>
                            <td><?= $distribucion['destino'] ?></td>
                            <td style="text-align: center;">
                                <button class="btn btn-warning btn-sm">
                                <?= $distribucion['cantidad'] ?>
                                </button>
                            </td>
                            <?php 
                                $dateString = $distribucion['fecha'];
                                $newDateString = date_format(date_create_from_format('Y-m-d', $dateString), 'd-m-Y');
                            ?>
                            <td><?= $newDateString ?></td>
                            <td style="text-align: center;">
                                <a onclick="view(<?php echo $distribucion['iddis']; ?>)" title="Ver Registro" href="" class="btn btn-primary btn-sm">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a onclick="updateDis(<?php echo $distribucion['iddis']; ?>)" href="#" title="Modificar Registro" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <a title="Generar Orden de Entrega N° <?= $distribucion['iddis'] ?>" class="btn btn-danger btn-sm" href="<?= $url = Url::toRoute(['distribucion/notaentrega', 'id' => $distribucion['iddis']]); ?>" target="_blank">
                                    <i class="fas fa-file-alt"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->render('modal_registrar_distribucion', [
        'model' => $model,
]) ?>

<?= $this->render('modal_view_distribucion', [
        'model' => $model,
]) ?>

<?= $this->render('modal_update_distribucion', [
        'model' => $model,
]) ?>

<?= $this->render('modal_responder_pedidos', [
        'model' => $model,
]) ?>



<?= $this->render('../site/preloader') ?>


<?php
$script = <<< JS

    $('.js-example-basic-single').select2({
        dropdownParent: $('#distribuirMedicamentos .modal-body'),
    });

    $('#distribucion-idsede').select2({
        dropdownParent: $('#distribuirMedicamentos .modal-body'),
    });

    $('#responder-pedido').select2({
        dropdownParent: $('#reponderPedidos .modal-body'),
    });

    $('#responder-idmedi').select2({
        dropdownParent: $('#reponderPedidos .modal-body'),
    });

    $('#responder-idsede').select2({
        dropdownParent: $('#reponderPedidos .modal-body'),
    });

    $('#distribucion-idmedi-update').select2({
        dropdownParent: $('#actualizarDisttribucion .modal-body'),
    });

    $('#distribucion-idsede-update').select2({
        dropdownParent: $('#actualizarDisttribucion .modal-body'),
    });




    //Modo Inicial - Default
    document.getElementById('distribucion-idsede').previousElementSibling.innerHTML = 'Destino';
    //Fin Modo Inicial - Default

    validateStringBlur("distribucion-descripcion"),
    validateNumberBlur("distribucion-idmedi"),
    validateNumberBlur("distribucion-idsede"),
    validateNumberBlur("distribucion-cantidad"),
  
    //Registrar distribución de Medicamento
    //-------------------------------------

    $("#registrar_distribucion").click(function(event) {

        event.preventDefault(); 

        document.querySelector(".preloader").setAttribute("style", "");

        var idmedi      = document.getElementById("distribucion-idmedi").value;
        var descripcion = document.getElementById("distribucion-descripcion").value;
        var destino      = document.getElementById("distribucion-idsede").value;
        var cantidad    = document.getElementById("distribucion-cantidad").value;

            //Verificar validacion
            //---------------------
            var VerficarValidacion = 
            [
                validateString("distribucion-descripcion"),
                validateNumber("distribucion-idmedi"),
                validateNumber("distribucion-idsede"),
                validateNumber("distribucion-cantidad"),
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
            
            var url = "sidmed.ve/index.php?r=distribucion/create";
            
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                            idmedi               : idmedi,
                            descripcion          : descripcion,
                            destino              : destino,
                            cantidad             : cantidad
                }
            })
            .done(function(response) {

                if (response.data.success == true) 
                {
                    document.querySelector(".preloader").style.display = 'none';
                    Swal.fire(
                    response.data.message,
                    'La Distribución se registro con el N° de entrega '+ response.data.correlativo +'',
                    'success'
                    );
                    $('#viewMedicamento').modal({ show:false });
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

//Fin registrar distribución de Medicamento
//-------------------------------------


//Responder Pedido
//-------------------------------------
$("#responder_pedido").click(function(event) {

event.preventDefault(); 

document.querySelector(".preloader").setAttribute("style", "");

var idmedi          = document.getElementById("responder-idmedi").value;
var descripcion     = document.getElementById("responder-descripcion").value;
var idpedi          = document.getElementById("responder-pedido").value;
var destino         = document.getElementById("responder-idsede").value;
var cantidad        = document.getElementById("responder-cantidad").value;


    //Verificar validacion
    //---------------------
    var VerficarValidacion = 
    [
        validateString("responder-descripcion"),
        validateNumber("responder-idmedi"),
        validateNumber("responder-pedido"),
        validateNumber("responder-idsede"),
        validateNumber("responder-cantidad"),
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
    
    var url = "sidmed.ve/index.php?r=distribucion/responderpedido";
    
    $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: {
                    idmedi          : idmedi,
                    descripcion     : descripcion,
                    idpedi          : idpedi,
                    destino         : destino,
                    cantidad        : cantidad
        }
    })
    .done(function(response) {

        if (response.data.success == true) 
        {
            document.querySelector(".preloader").style.display = 'none';
            Swal.fire(
            response.data.message,
            'El N° de Orden es '+ response.data.correlativo + '',
            'success'
            );
            $('#reponderPedidos').modal('hide');
            $('input[type="text"]').val('');
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

//Fin responder pedido
//--------------------

//Actualizar Distribucion de Medicamento
//--------------------------------
$("#modificar_distribucion").click(function(event) {

document.querySelector(".preloader").setAttribute("style", "");
event.preventDefault(); 

var iddis_update                       = document.getElementById("distribucion-iddis").value;
var distribucion_descripcion_update    = document.getElementById("distribucion-descripcion-update_e").value;
var distribucion_idmedi_update         = document.getElementById("distribucion-idmedi-update").value;
var distribucion_sede_update           = document.getElementById("distribucion-idsede-update").value;
var distribucion_cantidad_update       = document.getElementById("distribucion-cantidad-update").value;


var url = "http://sidmed.ve/index.php?r=distribucion/update";

//Verificar validacion
//---------------------
var VerficarValidacion = 
[
    validateString("distribucion-descripcion-update_e"),
    validateNumber("distribucion-idmedi-update"),
    validateNumber("distribucion-idsede-update"),
    validateNumber("distribucion-cantidad-update"),
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
                iddis_update                        : iddis_update, 
                distribucion_descripcion_update     : distribucion_descripcion_update,
                distribucion_idmedi_update          : distribucion_idmedi_update,
                distribucion_sede_update            : distribucion_sede_update,
                distribucion_cantidad_update        : distribucion_cantidad_update, 
    }
})
.done(function(response) {

    if (response.data.success == true) 
    {    
        document.querySelector(".preloader").style.display = 'none';
        Swal.fire(
        response.data.message,
        'El N° de entrega es '+ response.data.correlativo +'',
        'success'
        );
        //$('#actualizarDisttribucion').modal('hide');
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


//Fin Actualizar Distribucion de Medicamento
//------------------------------------------




//Filtrar canidad de medicamentos disponibles
   //-------------------------------------------
$("#distribucion-idmedi").change(function(event) {

let unidad = document.getElementById("distribucion-idmedi").value;
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


$("#responder-idmedi").change(function(event) {

let unidad = document.getElementById("responder-idmedi").value;
let cantidad_de_unidades = document.getElementById("reponder_cantidad_de_unidades");
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