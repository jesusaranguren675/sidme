<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntradasmedicamentosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recepción de Medicamentos';
$this->params['breadcrumbs'][] = $this->title;
?>



<script>
    //Modal ver Pedido
    //----------------
    function view(id) 
    {

            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_identrada = id;

            $('#viewRecepcion').modal({ show:true });

            var url = window.location.protocol+"/index.php?r=entradasmedicamentos/view";
    
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                    data_identrada : data_identrada
                }
            })
            .done(function(response) {
                if (response.data.success == true) 
                {
                    document.querySelector(".preloader").style.display = 'none';
                    
                    document.getElementById("data_1").innerHTML = response.data.identrada;
                    document.getElementById("data_2").innerHTML = response.data.nombre;
                    document.getElementById("data_3").innerHTML = response.data.presentacion;
                    document.getElementById("data_4").innerHTML = response.data.cantidad;
                    document.getElementById("data_5").innerHTML = response.data.fecha;

                    document.getElementById("viewRecepcionLabel").innerHTML = response.data.nombre+ " " + response.data.presentacion;
                }
            })
            .fail(function() {
                console.log("error");
            });
    //Fin Modal ver Pedido
    //--------------------
    }

    //Modal Modificar Recepción
    //----------------------
    function updateRe(id)
    {
            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_identrada= id;

            $('#actualizarRecepciones').modal({ show:true });
          
            var url = window.location.protocol+"/index.php?r=entradasmedicamentos/queryupdate";
    
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                    data_identrada : data_identrada
                }
            })
            .done(function(response) {
                if (response.data.success == true) 
                {
                    document.querySelector(".preloader").style.display = 'none';
                    
                    document.getElementById("identrada-update").setAttribute("value", response.data.identrada);
                    document.getElementById("entradasmedicamentos-descripcion-update").setAttribute("value", response.data.descripcion);
                    document.getElementById("entradasmedicamentos-cantidad-update").setAttribute("value", response.data.cantidad);
                    document.getElementById("entradasmedicamentos-idmedi-update-view").setAttribute("value", response.data.nombre+' '+response.data.presentacion);
                    document.getElementById("entradasmedicamentos-idmedi-update").setAttribute("value", response.data.idmedi);
                    document.getElementById("entradasmedicamentos-idsede-update-view").setAttribute("value", response.data.nombre_sede);
                    document.getElementById("entradasmedicamentos-idsede-update").setAttribute("value", response.data.procedencia);

                    
                    //document.getElementById("viewPedidoLabel").innerHTML = response.data.nombre+ " " + response.data.presentacion;
                }
            })
            .fail(function() {
                console.log("error");
            });
    }
    //Fin Modificar Modal Recepcion
    //------------------------------
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
    .modal-header .close {
        display: none;
    }

</style>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800" style="margin-top: 20px;"><?= Html::encode($this->title) ?></h1>
    <hr>

    <a class="btn btn-primary btn-sm"  href="<?= Url::toRoute('entradasmedicamentos/create'); ?> " data-toggle="modal" data-target="#agregarMedicamentos">
        Agregar 
        <i class="fas fa-plus"></i>
    </a>
    <a class="btn btn-danger btn-sm" href="<?= $url = Url::to(['entradasmedicamentos/report']) ?>" target="_blank">
        PDF <i class="far fa-file-pdf"></i>
    </a>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Medicamento</th>
                        <th>Presentación</th>
                        <th>Unidades</th>
                        <th>Organización</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entradas_medicamentos as $entradas_medicamentos): ?>
                        <tr>
                            <td><?= $entradas_medicamentos['identrada'] ?></td>
                            <td><?= $entradas_medicamentos['nombre'] ?></td>
                            <td><?= $entradas_medicamentos['presentacion'] ?></td>
                            <td style="text-align: center;">
                                <button class="btn btn-success btn-sm">
                                <?= $entradas_medicamentos['cantidad'] ?>
                                </button>
                            </td>
                            <td><?= $entradas_medicamentos['nombre_sede'] ?></td>
                            <td><?= $entradas_medicamentos['descripcion'] ?></td>
                            <?php 
                            $dateString = $entradas_medicamentos['fecha_entrada'];
                            $newDateString = date_format(date_create_from_format('Y-m-d', $dateString), 'd-m-Y');
                            ?>
                            <td width="150"><?= $newDateString ?></td>
                            <td style="text-align: center;">
                                <a onclick="view(<?= $entradas_medicamentos['identrada']; ?>)" href="" class="btn btn-primary btn-sm">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a onclick="updateRe(<?= $entradas_medicamentos['identrada']; ?>)" href="#" class="btn btn-primary btn-sm">
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

<?= $this->render('modal_registrar_recepcion', [
        'model' => $model,
]) ?>

<?= $this->render('modal_update_recepcion', [
        'model' => $model,
]) ?>

<?= $this->render('modal_view_recepcion', [
        'model' => $model,
]) ?>

<?= $this->render('../site/preloader') ?>

<?php
$script = <<< JS

    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            dropdownParent: $('#agregarMedicamentos .modal-body'),
        });
    });
      
      //Registrar Ingreso de Medicamento
      //--------------------------------

      validateStringBlur("entradasmedicamentos-descripcion"),
      validateNumberBlur("entradasmedicamentos-idmedi"),
      validateNumberBlur("entradasmedicamentos-idsede"),
      validateNumberBlur("entradasmedicamentos-cantidad"),


      validateStringBlur("entradasmedicamentos-descripcion-update"),
      validateNumberBlur("entradasmedicamentos-idmedi-update"),
      validateNumberBlur("entradasmedicamentos-idsede-update"),
      validateNumberBlur("entradasmedicamentos-cantidad-update"),

      $("#registrar_medicamento").click(function(event) {

            event.preventDefault(); 
            
            var descripcion = document.getElementById("entradasmedicamentos-descripcion").value;
            var idmedi      = document.getElementById("entradasmedicamentos-idmedi").value;
            //var idtipo      = document.getElementById("entradasmedicamentos-idtipo").value;
            var idsede      = document.getElementById("entradasmedicamentos-idsede").value;
            var cantidad    = document.getElementById("entradasmedicamentos-cantidad").value;
            
            //Verificar validacion
            //---------------------
            var VerficarValidacion = 
            [
                validateString("entradasmedicamentos-descripcion"),
                validateNumber("entradasmedicamentos-idmedi"),
                validateNumber("entradasmedicamentos-idsede"),
                validateNumber("entradasmedicamentos-cantidad"),
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
            
            var url = window.location.protocol+"/index.php?r=entradasmedicamentos/create";
            
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                            descripcion                 : descripcion,
                            idmedi                      : idmedi,
                            //idtipo                      : idtipo,
                            idsede                      : idsede,
                            cantidad                    : cantidad,
                }
            })
            .done(function(response) {

                if (response.data.success == true) 
                {
                    Swal.fire(
                    response.data.message,
                    '',
                    'success'
                    )

                    const myInterval = setInterval(myTimer, 2000);

                    function myTimer() {
                        location.reload();
                    }

                }
                else
                {
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

         //Fin registrar Ingreso de Medicamento
        //-------------------------------------


   //Actualizar Pedido de Medicamento
   //--------------------------------
   $("#modificar_repcion").click(function(event) {

document.querySelector(".preloader").setAttribute("style", "");
event.preventDefault(); 

var identrada                = document.getElementById("identrada-update").value;
var descripcion              = document.getElementById("entradasmedicamentos-descripcion-update").value;
var idmedi                   = document.getElementById("entradasmedicamentos-idmedi-update").value;
var idsede                   = document.getElementById("entradasmedicamentos-idsede-update").value;
var cantidad                 = document.getElementById("entradasmedicamentos-cantidad-update").value;



var url = window.location.protocol+"/index.php?r=entradasmedicamentos/update";

//Verificar validacion
//---------------------
var VerficarValidacion = 
[
    //validateNumber("identrada-update"),
    validateString("entradasmedicamentos-descripcion-update"),
    validateNumber("entradasmedicamentos-idmedi-update"),
    validateNumber("entradasmedicamentos-idsede-update"),
    validateNumber("entradasmedicamentos-cantidad-update"),
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
    data: 
    {
        identrada     : identrada,
        descripcion   : descripcion,
        idmedi        : idmedi,
        idsede        : idsede,
        cantidad      : cantidad  
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
JS;
$this->registerJs($script);
?>