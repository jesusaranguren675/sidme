<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\MedicamentosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Medicamentos';
$this->params['breadcrumbs'][] = $this->title;

$idusu = Yii::$app->user->identity->id;
$roles = Yii::$app->db->createCommand("SELECT usuario.id, 
        usuario.username, rol.nombre_rol FROM asignacion_roles AS asignacion
        JOIN public.user AS usuario
        ON usuario.id=asignacion.id_usu
        JOIN roles AS rol
        ON rol.id_rol=asignacion.id_rol
        WHERE usuario.id=$idusu")->queryAll();

foreach ($roles as $roles) 
{
$usuario = $roles['username'];
$rol     = $roles['nombre_rol'];
}

?>
<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<script>
    //Modal ver Pedido
    //----------------
    function view(id) 
    {

            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_id_detalle_medi = id;

            $('#viewMedicamento').modal({ show:true });

            var url = window.location.protocol+"/index.php?r=medicamentos/view";
    
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                    data_id_detalle_medi : data_id_detalle_medi
                }
            })
            .done(function(response) {
                if (response.data.success == true) 
                {
                    document.querySelector(".preloader").style.display = 'none';
                    
                    document.getElementById("data_1").innerHTML = response.data.id_detalle_medi;
                    document.getElementById("data_2").innerHTML = response.data.nombre;
                    document.getElementById("data_3").innerHTML = response.data.descripcion;

                    document.getElementById("viewMedicamentoLabel").innerHTML = response.data.nombre+ " " + response.data.descripcion;
                }
            })
            .fail(function() {
                console.log("error");
            });
    //Fin Modal ver Pedido
    //--------------------
    }

    //Modal Modificar Recepción
    //-------------------------
    function updateMe(id)
    {
            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let id_detalle_medi = id;

            $('#actualizarMedicamentos').modal({ show:true });
          
            var url = window.location.protocol+"/index.php?r=medicamentos/queryupdate";
    
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                    id_detalle_medi : id_detalle_medi
                }
            })
            .done(function(response) {
                if (response.data.success == true) 
                {
                    document.querySelector(".preloader").style.display = 'none';
                    
                    document.getElementById("id_detalle_medi-update").setAttribute("value", response.data.id_detalle_medi);
                    document.getElementById("nombre-update").setAttribute("value", response.data.nombre);
                    document.getElementById("idmedi-update").setAttribute("value", response.data.idmedi);
                    
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

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800" style="margin-top: 20px;"><?= Html::encode($this->title) ?></h1>
    <hr>

    <?php

    if($rol == 'Empleado')
    {
        
    }
    else if($rol == 'Administrador' || $rol == 'Coordinador')
    {
        ?>
        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#medicamento">
        Agregar <i class="fas fa-plus"></i>
        </a>
        <?php
    }

    ?>
    
    <a class="btn btn-danger btn-sm" href="<?= $url = Url::to(['medicamentos/report']) ?>" target="_blank">
        PDF <i class="far fa-file-pdf"></i>
    </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($medicamentos as $medicamentos): ?>
                        <tr>
                            <td><?= $medicamentos['id_detalle_medi'] ?></td>
                            <td><?= ucwords($medicamentos['nombre']) ?></td>
                            <td><?= ucwords($medicamentos['descripcion']) ?></td>
                            <td style="text-align: center;">
                                <a onclick="view(<?= $medicamentos['id_detalle_medi']; ?>)" href="#" class="btn btn-primary btn-sm">
                                    <i class="far fa-eye"></i>
                                </a>
                                <?php
                                if($rol == 'Empleado')
                                {

                                }
                                else if($rol == 'Administrador' || $rol == 'Coordinador')
                                {
                                    ?>
                                    <a onclick="updateMe(<?= $medicamentos['id_detalle_medi']; ?>)" href="#" class="btn btn-primary btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <?php
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->render('modal_registrar_medicamento', [
        'model' => $model,
]) ?>

<?= $this->render('modal_view_medicamento', [
        'model' => $model,
]) ?>

<?= $this->render('modal_update_medicamento', [
        'model' => $model,
]) ?>

<?= $this->render('../site/preloader') ?>

<?php
$script = <<< JS

    var nombre  = document.getElementById("medicamentos-nombre").value;

    validateStringBlur("medicamentos-nombre");
    validateStringBlur("presentacion");

    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            dropdownParent: $('#medicamento .modal-body'),
        });
    });

    //Registrar Medicamento
    //--------------------------------

    $("#registrar_medicamento").click(function(event) {
    
        document.querySelector(".preloader").setAttribute("style", "");
        event.preventDefault(); 
        
        var nombre  = document.getElementById("medicamentos-nombre").value;
        var presentacion  = document.getElementById("presentacion").value;
  
        var url =   window.location.protocol+"/index.php?r=medicamentos/create";

            //Verificar validacion
            //---------------------
            var VerficarValidacion = 
            [
                validateString("medicamentos-nombre"),
                validateNumber("presentacion"),
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
                      nombre            : nombre,
                      presentacion      : presentacion,
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
             response.data.info,
             'error'
             )
          }
       
        })
        .fail(function() {
          console.log("error");
        });
    });
    //Fin registrar Medicamento
   //--------------------------

   //Actualizar Pedido de Medicamento
   //--------------------------------
   $("#modificar_medicamento").click(function(event) {

document.querySelector(".preloader").setAttribute("style", "");
event.preventDefault(); 

var id_detalle_medi        = document.getElementById("id_detalle_medi-update").value;
var idmedi                 = document.getElementById("idmedi-update").value;
var nombre_update          = document.getElementById("nombre-update").value;
var presentacion_update    = document.getElementById("presentacion-update").value;

var url = window.location.protocol+"/index.php?r=medicamentos/update";

//Verificar validacion
//---------------------
var VerficarValidacion = 
[
    validateString("nombre-update"),
    validateNumber("presentacion-update"),
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
                idmedi                        : idmedi,
                id_detalle_medi               : id_detalle_medi, 
                nombre_update                 : nombre_update, 
                presentacion_update           : presentacion_update,
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


//Fin Actualizar Pedido de Medicamento
//------------------------------------
JS;
$this->registerJs($script);
?>