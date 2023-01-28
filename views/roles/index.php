<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\RolesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Roles';
$this->params['breadcrumbs'][] = $this->title;
?>

<script>
    //Modal ver Rol
    //----------------
    function view(id) 
    {

            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_id_rol = id;

            $('#viewRol').modal({ show:true });

            var url = window.location.protocol+"/index.php?r=roles/view";
    
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                    data_id_rol : data_id_rol
                }
            })
            .done(function(response) {
                if (response.data.success == true) 
                {
                    document.querySelector(".preloader").style.display = 'none';
                    
                    document.getElementById("data_1").innerHTML = response.data.id_rol;
                    document.getElementById("data_2").innerHTML = response.data.nombre_rol;
                    document.getElementById("data_3").innerHTML = response.data.create_at;


                    document.getElementById("viewRolLabel").innerHTML = "Rol: "+ response.data.nombre_rol;
                }
            })
            .fail(function() {
                console.log("error");
            });
    //Fin Modal ver Rol
    //--------------------
    }

    //Modal Modificar Rol
    //----------------------
    function updateRe(id)
    {
            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_id_rol = id;

            $('#actualizarRoles').modal({ show:true });
          
            var url = window.location.protocol+"/index.php?r=roles/queryupdate";
    
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                    data_id_rol : data_id_rol
                }
            })
            .done(function(response) {
                if (response.data.success == true) 
                {
                    document.querySelector(".preloader").style.display = 'none';
                    
                    document.getElementById("id_rol_update").setAttribute("value", response.data.id_rol);
                    document.getElementById("nombre_rol_update").setAttribute("value", response.data.nombre_rol);
                    
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

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800" style="margin-top: 20px;"><?= Html::encode($this->title) ?></h1>
    <hr>

    <a class="btn btn-primary btn-sm"  href="<?= Url::toRoute('roles/create'); ?> " data-toggle="modal" data-target="#agregarRol">
        Agregar 
        <i class="fas fa-plus"></i>
    </a>
    <a class="btn btn-danger btn-sm" href="<?= $url = Url::to(['roles/report']) ?>" target="_blank">
        PDF <i class="far fa-file-pdf"></i>
    </a>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Rol</th>
                        <th>Fecha</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($roles as $roles): ?>
                        <tr>
                            <td><?= $roles['id_rol'] ?></td>
                            <td><?= ucwords($roles['nombre_rol']) ?></td>
                            <td><?= $roles['create_at'] ?></td>
                            <td style="text-align: center;">
                                <a onclick="view(<?= $roles['id_rol']; ?>)" href="" class="btn btn-primary btn-sm">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a onclick="updateRe(<?= $roles['id_rol']; ?>)" href="#" class="btn btn-primary btn-sm">
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

<?= $this->render('modal_registrar_rol', [
        'model' => $model,
]) ?>

<?= $this->render('modal_view_rol', [
        'model' => $model,
]) ?>

<?= $this->render('modal_update_roles', [
        'model' => $model,
]) ?>

<?= $this->render('../site/preloader') ?>

<?php

$script = <<< JS

      
      //Registrar Ingreso de Medicamento
      //--------------------------------

      validateStringBlur("roles-nombre_rol"),
      

      $("#registrar_roles").click(function(event) {

            event.preventDefault(); 
            
            var nombre_rol = document.getElementById("roles-nombre_rol").value;

            
            //Verificar validacion
            //---------------------
            var VerficarValidacion = 
            [
                validateString("roles-nombre_rol"),
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
            
            var url = window.location.protocol+"/index.php?r=roles/create";
            
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                            nombre_rol       :     nombre_rol,
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


   //Actualizar Rol
   //--------------------------------
   $("#modificar_rol").click(function(event) {

document.querySelector(".preloader").setAttribute("style", "");
event.preventDefault(); 

var id_rol_update            = document.getElementById("id_rol_update").value;
var nombre_rol_update              = document.getElementById("nombre_rol_update").value;




var url = window.location.protocol+"/index.php?r=roles/update";

//Verificar validacion
//---------------------
var VerficarValidacion = 
[
    //validateNumber("identrada-update"),
    validateString("nombre_rol_update"),
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
        id_rol_update       : id_rol_update,
        nombre_rol_update   : nombre_rol_update,
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

        const myInterval = setInterval(myTimer, 2000);

        function myTimer() {
        location.reload();
        }
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


//Fin Actualizar Rol
//------------------------------------
JS;
$this->registerJs($script);
?>
