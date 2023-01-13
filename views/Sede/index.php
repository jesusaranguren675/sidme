<?php

use app\models\Sede;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\SedeSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Sedes';
$this->params['breadcrumbs'][] = $this->title;
?>

<script>
    //Modal ver Sede
    //----------------
    function view(id) 
    {

            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_idsede = id;

            $('#viewSede').modal({ show:true });

            var url = "http://sidmed.ve/index.php?r=sede/view";
    
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                    data_idsede : data_idsede
                }
            })
            .done(function(response) {
                if (response.data.success == true) 
                {
                    console.log(response.data);

                    document.querySelector(".preloader").style.display = 'none';
                                        
                    document.getElementById("data_1").innerHTML = response.data.idsede;

                    document.getElementById("data_2").innerHTML = response.data.nombre;
                    document.getElementById("data_3").innerHTML = response.data.ubicacion;
                    document.getElementById("data_4").innerHTML = response.data.telefono;
                    document.getElementById("data_5").innerHTML = response.data.correo;


                    document.getElementById("viewRecepcionLabel").innerHTML = response.data.nombre+ " " + response.data.presentacion;
                }
            })
            .fail(function() {
                console.log("error");
            });
    //Fin Modal ver Sede
    //--------------------
    }

    //Modal Modificar Sede
    //----------------------
    function updateSe(id)
    {
            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_idsede = id;

            $('#actualizarSedes').modal({ show:true });

            var url = "http://sidmed.ve/index.php?r=sede/queryupdate";
    
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                    data_idsede : data_idsede
                }
            })
            .done(function(response) {
                if (response.data.success == true) 
                {
                    document.querySelector(".preloader").style.display = 'none';
                    
                    document.getElementById("idsede-update").setAttribute("value", response.data.idsede);
                    document.getElementById("nombre-update").setAttribute("value", response.data.nombre);
                    document.getElementById("ubicacion-update").setAttribute("value", response.data.ubicacion);
                    document.getElementById("telefono-update").setAttribute("value", response.data.telefono);
                    document.getElementById("correo-update").setAttribute("value", response.data.correo);


                    //document.getElementById("viewPedidoLabel").innerHTML = response.data.nombre+ " " + response.data.presentacion;
                }
            })
            .fail(function() {
                console.log("error");
            });
    }
    //Fin Modificar Modal ver Sede
    //------------------------------
</script>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800" style="margin-top: 20px;"><?= Html::encode($this->title) ?></h1>
    <hr>

    <a class="btn btn-primary btn-sm"  href="<?= Url::toRoute('entradasmedicamentos/create'); ?> " data-toggle="modal" data-target="#registrarSede">
        Agregar 
        <i class="fas fa-plus"></i>
    </a>
    <a class="btn btn-danger btn-sm" href="<?= $url = Url::to(['sede/report']) ?>" target="_blank">
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
                        <th>ubicación</th>
                        <th>Telefono</th>
                        <th>Correo</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $contador = 1; ?>
                    <?php foreach ($sedes as $sedes): ?>
                        <tr>
                            <td><?= $contador ?></td>
                            <td><?= $sedes['nombre'] ?></td>
                            <td><?= $sedes['ubicacion'] ?></td>
                            <td><?= $sedes['telefono'] ?></td>
                            <td><?= $sedes['correo'] ?></td>
                            <td style="text-align: center;">
                                <a onclick="view(<?= $sedes['idsede']; ?>)" href="" class="btn btn-primary btn-sm">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a onclick="updateSe(<?= $sedes['idsede']; ?>)" href="#" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php $contador = $contador + 1; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->render('modal_registrar_sede', [
        'model' => $model,
]) ?>

<?= $this->render('modal_view_sede', [
        'model' => $model,
]) ?>

<?= $this->render('modal_update_sede', [
        'model' => $model,
]) ?>

<?= $this->render('../site/preloader') ?>

<?php
$script = <<< JS
      
      //Registrar Ingreso de Medicamento
      //--------------------------------

      validateStringBlur("sede-nombre"),
      validateStringBlur("sede-ubicacion"),
      validateNumberBlur("sede-telefono"),
      validateStringBlur("sede-correo"),


      $("#registrar_sede").click(function(event) {
            document.querySelector(".preloader").setAttribute("style", "");

            event.preventDefault(); 
            
            var nombre          = document.getElementById("sede-nombre").value;
            var ubicacion       = document.getElementById("sede-ubicacion").value;
            var telefono        = document.getElementById("sede-telefono").value;
            var correo          = document.getElementById("sede-correo").value;            
            //Verificar validacion
            //---------------------
            var VerficarValidacion = 
            [
                validateString("sede-nombre"),
                validateString("sede-ubicacion"),
                validateNumber("sede-telefono"),
                validateString("sede-correo"),
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
            
            var url = "http://sidmed.ve/index.php?r=sede/create";
            
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                            nombre                : nombre,
                            ubicacion             : ubicacion,
                            telefono              : telefono,
                            correo                : correo,
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
                    )

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

         //Fin registrar Ingreso de Medicamento
        //-------------------------------------

//Actualizar Sede
   //--------------------------------
   $("#modificar_sede").click(function(event) {

    document.querySelector(".preloader").setAttribute("style", "");
    event.preventDefault(); 

    var idsede                = document.getElementById("idsede-update").value;
    var nombre                = document.getElementById("nombre-update").value;
    var ubicacion             = document.getElementById("ubicacion-update").value;
    var telefono              = document.getElementById("telefono-update").value;
    var correo                = document.getElementById("correo-update").value;


    var url = "http://sidmed.ve/index.php?r=sede/update";

    //Verificar validacion
    //---------------------
    var VerficarValidacion = 
    [
        validateString("nombre-update"),
        validateString("ubicacion-update"),
        validateNumber("telefono-update"),
        validateString("correo-update"),
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
                    idsede                 : idsede , 
                    nombre                 : nombre,
                    ubicacion              : ubicacion,
                    telefono               : telefono,
                    correo                 : correo
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
    //Fin Actualizar Sede
    //------------------------------------


   
JS;
$this->registerJs($script);
?>