<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\log\Target;

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
        <a class="btn btn-primary btn-sm"  href="<?= Url::toRoute('entradasmedicamentos/create'); ?> " data-toggle="modal" data-target="#distribuirMedicamentos">
        Agregar <i class="fas fa-plus"></i>
        </a>
        <a class="btn btn-danger btn-sm" href="<?= $url = Url::to(['pedidos/report']) ?>" target="_blank">
            PDF <i class="far fa-file-pdf"></i>
        </a>
        <a class="btn btn-success btn-sm">EXCEL <i class="far fa-file-excel"></i></a>
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
                        <th>Estatus</th>
                        <th>Fecha</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedidos): ?>
                        <tr>
                            <td><?= $pedidos['idpedi'] ?></td>
                            <td><?= $pedidos['descripcion'] ?></td>
                            <td width="100"><?= $pedidos['nombre'] ?></td>
                            <td><?= $pedidos['presentacion'] ?></td>
                            <td style="text-align: center;">
                                <button class="btn btn-warning btn-sm">
                                <?= $pedidos['cantidad'] ?>
                                </button>
                            </td>
                            <td style="text-align: center;">
                                <?php
                                if($pedidos['estatus'] === 1)
                                {
                                    ?>
                                    <button class="btn btn-success btn-sm">Aprobado</button>
                                    <?php
                                }
                                if($pedidos['estatus'] === 2)
                                {
                                    ?>
                                    <button class="btn btn-primary btn-sm">Pendiente</button>
                                    <?php
                                }
                                if($pedidos['estatus'] === 3)
                                {
                                    ?>
                                    <button class="btn btn-danger btn-sm">Rechazado</button>
                                    <?php
                                }
                                ?>
                            </td>
                            <td><?= $pedidos['fecha'] ?></td>
                            <td style="text-align: center;">
                                <a id="view_<?php echo $pedidos['idpedi']; ?>"
                                   data-idpedi="<?php echo $pedidos['idpedi']; ?>" 
                                   href="" 
                                   class="btn btn-primary btn-sm view_btn">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a id="<?php echo $pedidos['idpedi']; ?>" 
                                   data-descripcion="<?= $pedidos['descripcion'] ?>"
                                   data-nombre="<?= $pedidos['nombre'] ?>"
                                   data-presentacion="<?= $pedidos['presentacion'] ?>"
                                   data-cantidad="<?= $pedidos['cantidad'] ?>" 
                                   href="#" 
                                   class="btn btn-primary btn-sm update_btn">
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


<?= $this->render('modal_view_pedidos', [
        'model' => $model,
]) ?>

<?= $this->render('modal_registrar_pedidos', [
        'model' => $model,
]) ?>


<?= $this->render('modal_update_pedidos', [
        'model' => $model,
]) ?>

<?= $this->render('../site/preloader') ?>

<?php
$script = <<< JS

    var descripcion             = document.getElementById("pedido-descripcion").value;
    var idmedi                  = document.getElementById("pedido-idmedi").value;
    var procedencia             = document.getElementById("pedido-sede").value;
    var cantidad                = document.getElementById("pedido-cantidad").value;
    var cantidad_de_unidades    = document.getElementById("cantidad_de_unidades");
    var estatus                 = document.getElementById("pedido-estatus").value;

    validateStringBlur("pedido-descripcion");
    validateNumberBlur("pedido-idmedi");
    validateNumberBlur("pedido-sede");
    validateNumberBlur("pedido-cantidad");
    validateNumberBlur("pedido-estatus");
    
    document.getElementById('pedido-sede').previousElementSibling.innerHTML = 'Procedencia';


     //Registrar Pedido de Medicamento
    //--------------------------------

    $("#registrar_pedido").click(function(event) {
    
        document.querySelector(".preloader").setAttribute("style", "");
        event.preventDefault(); 

        var descripcion             = document.getElementById("pedido-descripcion").value;
        var idmedi                  = document.getElementById("pedido-idmedi").value;
        var procedencia             = document.getElementById("pedido-sede").value;
        var cantidad                = document.getElementById("pedido-cantidad").value;
        var cantidad_de_unidades    = document.getElementById("cantidad_de_unidades");
        var estatus                 = document.getElementById("pedido-estatus").value;


    
      
      var url = "http://sidmed.ve/index.php?r=pedidos/create";

            //Verificar validacion
            //---------------------
            var VerficarValidacion = 
            [
                validateString("pedido-descripcion"),
                validateNumber("pedido-idmedi"),
                validateNumber("pedido-sede"),
                validateNumber("pedido-cantidad"),
                validateNumber("pedido-estatus"),
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
                      descripcion               : descripcion,
                      idmedi                    : idmedi,
                      procedencia               : procedencia,
                      cantidad                  : cantidad,
                      estatus                   : estatus,

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

    //Fin registrar Pedido de Medicamento
   //-------------------------------------------

     //Actualizar Pedido de Medicamento
    //---------------------------------

    let update_btn = document.querySelectorAll(".update_btn");

    for (let i = 0; i < update_btn.length; i++)
    {
        update_btn[i].addEventListener('click', function(){

            let idpedi = update_btn[i].getAttribute('id');
            let descripcion = update_btn[i].getAttribute('data-descripcion');
            let nombre = update_btn[i].getAttribute('data-nombre');
            let presentacion = update_btn[i].getAttribute('data-presentacion');
            let cantidad = update_btn[i].getAttribute('data-cantidad');

            $('#actualizarMedicamentos').modal({ show:true });
            
            document.getElementById("pedido-descripcion-update").setAttribute("value", descripcion);
            document.getElementById("pedido-cantidad-update").setAttribute("value", cantidad);
            document.getElementById("idpedi-update").setAttribute("value", idpedi);

        }, false);
            
    }

    $("#modificar_pedido").click(function(event) {
    
        document.querySelector(".preloader").setAttribute("style", "");
        event.preventDefault(); 

        var idpedi_update                = document.getElementById("idpedi-update").value;
        var pedido_descripcion_update    = document.getElementById("pedido-descripcion-update").value;
        var pedido_idmedi_update         = document.getElementById("pedido-idmedi-update").value;
        var pedido_sede_update           = document.getElementById("pedido-sede-update").value;
        var pedido_cantidad_update       = document.getElementById("pedido-cantidad-update").value;
        var pedido_estatus_update        = document.getElementById("pedido-estatus-update").value;

        var url = "http://sidmed.ve/index.php?r=pedidos/update";

        //Verificar validacion
        //---------------------
        var VerficarValidacion = 
        [
            validateString("pedido-descripcion-update"),
            validateNumber("pedido-idmedi-update"),
            validateNumber("pedido-sede-update"),
            validateNumber("pedido-cantidad-update"),
            validateNumber("pedido-estatus-update"),
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
                            idpedi_update                 : idpedi_update , 
                            pedido_descripcion_update     : pedido_descripcion_update,
                            pedido_idmedi_update          : pedido_idmedi_update,
                            pedido_sede_update            : pedido_sede_update,
                            pedido_cantidad_update        : pedido_cantidad_update,
                            pedido_estatus_update         : pedido_estatus_update,

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

    //Ver Registro del Pedido
    //-----------------------
    let view_btn = document.querySelectorAll(".view_btn");

    for (let view = 0; view < view_btn.length; view++)
    {
         
        view_btn[view].addEventListener('click', function(e){
            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_idpedi = view_btn[view].getAttribute('data-idpedi');

            $('#viewPedido').modal({ show:true });

            var url = "http://sidmed.ve/index.php?r=pedidos/view";
    
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                    data_idpedi : data_idpedi
                }
            })
            .done(function(response) {
                if (response.data.success == true) 
                {
                    document.querySelector(".preloader").style.display = 'none';
                    
                    document.getElementById("data_1").innerHTML = response.data.idpedi;
                    document.getElementById("data_2").innerHTML = response.data.descripcion;
                    document.getElementById("data_3").innerHTML = response.data.nombre;
                    document.getElementById("data_4").innerHTML = response.data.presentacion;
                    document.getElementById("data_5").innerHTML = response.data.cantidad;
                    document.getElementById("data_7").innerHTML = response.data.fecha;

                    if(response.data.estatus === 1){
                        document.getElementById("data_6").innerHTML = '<button class="btn btn-success btn-sm">Aprobado</button>';
                    }

                    if(response.data.estatus === 2){
                        document.getElementById("data_6").innerHTML = '<button class="btn btn-primary btn-sm">Pendiente</button>';
                    }

                    if(response.data.estatus === 3){
                        document.getElementById("data_6").innerHTML = '<button class="btn btn-danger btn-sm">Rechazado</button>';
                    }

                    document.getElementById("viewPedidoLabel").innerHTML = response.data.nombre+ " " + response.data.presentacion;
                }
            })
            .fail(function() {
                console.log("error");
            });

            /*
            document.getElementById("pedido-descripcion-update").setAttribute("value", descripcion);
            document.getElementById("pedido-cantidad-update").setAttribute("value", cantidad);
            document.getElementById("idpedi-update").setAttribute("value", idpedi);
            */

        }, false);
               
    }
    //Fin ver Registro del Pedido
    //---------------------------

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
