<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

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
        <a class="btn btn-danger btn-sm">pdf <i class="far fa-file-pdf"></i></a>
        <a class="btn btn-success btn-sm">excel <i class="far fa-file-excel"></i></a>
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
                                <a onclick="ver_medica(<?php echo $pedidos['idpedi']; ?>)" href="" class="btn btn-primary btn-sm">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a  href="<?= Url::to(['pedidos/update', 'idpedi' => $pedidos['idpedi']]); ?>" class="btn btn-primary btn-sm">
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

<!-- Modal Distribuir Medicamentos -->
<div class="modal fade" id="distribuirMedicamentos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="distribuirMedicamentosLabel" aria-hidden="true">
  <div style="position:relative;" class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="distribuirMedicamentosLabel">Registrar Pedido</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= $this->render('create', [
        'model' => $model,
        ]) ?>
      </div>
      <div class="modal-footer"><!-- data-dismiss="modal" -->
        <button id="back" type="button" class="btn btn-secondary" data-dismiss="modal" >Cerrar</button>
        <button id="registrar_pedido" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>

<div class="preloader" style="display:none;">
    <img src="<?=  Url::to('@web/img/preloader.gif') ?>" alt="">
</div>
<!-- Fin Modal Distribuir Medicamentos -->

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

     //Registrar distribución de Medicamento
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
                    'Verifica que los campos tengas los valores correspondientes.',
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

    //Fin registrar distribución de Medicamento
   //-------------------------------------------

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
    //Filtrar canidad de medicamentos disponibles
   //-------------------------------------------

JS;
$this->registerJs($script);
?>
