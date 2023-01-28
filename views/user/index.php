<?php

use app\models\Usuario;
use app\models\user;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UserSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = $this->title;
?>

<script>
        //Modal ver Sede
    //----------------
    function view(id) 
    {
            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_id = id;

            $('#viewUsuario').modal({ show:true });

            var url = window.location.protocol+"/index.php?r=user/view";
    
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                    data_id : data_id
                }
            })
            .done(function(response) {
                if (response.data.success == true) 
                {
                    console.log(response.data);

                    document.querySelector(".preloader").style.display = 'none';
                                        
                    document.getElementById("data_1").innerHTML = response.data.id;
                    document.getElementById("data_2").innerHTML = response.data.username;
                    document.getElementById("data_3").innerHTML = response.data.email;
                    document.getElementById("data_4").innerHTML = response.data.nombre_rol;
                    if(response.data.estatus == 1){
                        document.getElementById("data_5").innerHTML = 'Activo';
                    }else{
                        document.getElementById("data_5").innerHTML = 'Inactivo';
                    }
                    document.getElementById("data_6").innerHTML = response.data.fecha;


                    document.getElementById("viewUsuarioLabel").innerHTML = response.data.username;
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
    function updateUsu(id)
    {
            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_id = id;

            $('#actualizarUsuarios').modal({ show:true });

            var url = window.location.protocol+"/index.php?r=user/queryupdate";
    
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                    data_id : data_id
                }
            })
            .done(function(response) {
                if (response.data.success == true) 
                {
                    document.querySelector(".preloader").style.display = 'none';
                    
                    document.getElementById("id-usuario").setAttribute("value", response.data.id);
                    document.getElementById("username-update").setAttribute("value", response.data.username);
                    //document.getElementById("password_hash-update").setAttribute("value", response.data.nombre);
                    document.getElementById("email-update").setAttribute("value", response.data.email);
                    document.getElementById("etatus-update").setAttribute("value", response.data.estatus);
                    document.getElementById("rol-update").setAttribute("value", response.data.nombre_rol);


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
        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalUsuarios"  href="<?= Url::toRoute('user/create'); ?> " data-toggle="modal" data-target="#modalUsuarios">
        Agregar <i class="fas fa-plus"></i>
        </a>
        <a class="btn btn-danger btn-sm" href="<?= $url = Url::to(['user/report']) ?>" target="_blank">
            PDF <i class="far fa-file-pdf"></i>
        </a>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estatus</th>
                        <th>Fecha</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuarios): ?>
                        <tr>
                            <td><?= $usuarios['id'] ?></td>
                            <td><?= $usuarios['username'] ?></td>
                            <td width="200"><?= $usuarios['email'] ?></td>
                            <td><?= $usuarios['nombre_rol'] ?></td>
                            <td style="text-align: center;">
                                <?php
                                    if($usuarios['estatus'] === 0)
                                    {   
                                        ?>
                                            <button class="btn btn-danger btn-sm">
                                            Inactivo
                                            </button>
                                        <?php
                                    }
                                    else{
                                        ?>
                                            <button class="btn btn-success btn-sm">
                                            Activo
                                            </button>
                                        <?php
                                    }
                                ?>
                            </td>
                            <td><?= $usuarios['fecha'] ?></td>
                            <td style="text-align: center;">
                                <a onclick="view(<?= $usuarios['id']; ?>)" href="" class="btn btn-primary btn-sm">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a onclick="updateUsu(<?= $usuarios['id']; ?>)" href="#" class="btn btn-primary btn-sm">
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

<?= $this->render('modal_view_usuario', [
        'model' => $model,
]) ?>

<?= $this->render('modal_update_usuario', [
        'model' => $model,
]) ?>

<?= $this->render('../site/preloader') ?>

<?= $this->render('modal_registrar_usuario', [
        'model' => $model,
]) ?>




<?php
$script = <<< JS

 
      $("#registrar_usuario").click(function(event) {

            event.preventDefault(); 
            
            var username           = document.getElementById("usuario-username").value;
            var password_hash      = document.getElementById("usuario-password_hash").value;
            var email              = document.getElementById("usuario-email").value;
            var status             = document.getElementById("usuario-status").value;
            var rol                = document.getElementById("usuario-rol").value;
            
    

            var url = "sidmed.ve/index.php?r=user/create";
            
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                            username          : username,
                            password_hash     : password_hash,
                            email             : email,
                            status            : status,
                            rol               : rol,
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

         //Fin Registrar Usuario
        //-------------------------------------


        //Actualizar Sede
   //--------------------------------
   $("#modificar_usuario").click(function(event) {

document.querySelector(".preloader").setAttribute("style", "");
event.preventDefault(); 

var id                 = document.getElementById("id-usuario").value;
var username           = document.getElementById("username-update").value;
var password_hash      = document.getElementById("password_hash-update").value;
var email              = document.getElementById("email-update").value;
var status             = document.getElementById("etatus-update").value;
var rol                = document.getElementById("rol-update").value;

var url = window.location.protocol+"/index.php?r=user/update";

//Verificar validacion
//---------------------
var VerficarValidacion = 
[
    validateString("username-update"),
    validateNumber("password_hash-update"),
    validateString("email-update"),
    validateNumber("etatus-update"),
    validateNumber("rol-update"),
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
                id                : id,
                username          : username,
                password_hash     : password_hash,
                email             : email,
                status            : status,
                rol               : rol,
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