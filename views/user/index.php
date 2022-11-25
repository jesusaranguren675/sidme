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
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800" style="margin-top: 20px;"><?= Html::encode($this->title) ?></h1>
        <hr>
        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalUsuarios"  href="<?= Url::toRoute('user/create'); ?> " data-toggle="modal" data-target="#modalUsuarios">
        Agregar <i class="fas fa-plus"></i>
        </a>
        <a class="btn btn-danger btn-sm">pdf <i class="far fa-file-pdf"></i></a>
        <a class="btn btn-success btn-sm">excel <i class="far fa-file-excel"></i></a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                <tfoot>
                    <tr>
                        <th>N°</th>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estatus</th>
                        <th>Fecha</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </tfoot>
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
                                <a onclick="ver_medica(<?php echo $usuarios['id']; ?>)" href="" class="btn btn-primary btn-sm">
                                    <i class="far fa-eye"></i>
                                </a>
                                <?php $selector = "btn btn-primary btn-sm modificar-usuario modificar-usuario-".$usuarios['id']; ?>
                                <a data-id="<?php echo $usuarios['id']; ?>" href="#" class="<?= $selector ?>">
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

<!-- Modal Agregar Usuarios -->

<div class="modal fade" id="modalUsuarios" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalUsuariosLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalUsuariosLabel">Agregar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= $this->render('create', [
        'model' => $model,
        ]) ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="registrar_usuario" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal Agregar Usuarios -->

<!-- Modal Actualizar Usuarios -->

<div class="modal fade" id="modalActualizarUsuarios" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalActualizarUsuariosLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalActualizarUsuariosLabel">Modificar Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= $this->render('create', [
        'model' => $model,
        ]) ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="modificar_usuario" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal Actualizar Usuarios -->


<?php
$script = <<< JS

    let modificar_usuario = document.querySelectorAll('.modificar-usuario');

    for (let i = 0; i < modificar_usuario.length; i++) {
        modificar_usuario[i].addEventListener('click', modificarUsuario, false);
    }

    function modificarUsuario(e)
    {
        console.log(e);

        //let elemento = e.target.getAttribute('class');

        //parametro = "'."+elemento+"'";

        //console.log(elemento)

        //let elemento2 = document.querySelector(parametro);

        //console.log(elemento2);
    }
      //Registrar Usuario
      //--------------------------------

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

    
//Modificar Usuario
//--------------------------------


$("#modificar_usuario").click(function(event) {

event.preventDefault(); 


var username           = document.getElementById("usuario-username").value;
var password_hash      = document.getElementById("usuario-password_hash").value;
var email              = document.getElementById("usuario-email").value;
var status             = document.getElementById("usuario-status").value;
var rol                = document.getElementById("usuario-rol").value;

username.setAttribute('value', username);
password_hash.setAttribute('value', password_hash);
email.setAttribute('value', email);
status.setAttribute('value', status);
rol.setAttribute('value', rol);

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

//Fin Modificar Usuario
//-------------------------------------
JS;
$this->registerJs($script);
?>