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
                        <th>Fecha</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>N°</th>
                        <th>Descripción</th>
                        <th>Nombre</th>
                        <th>Presentación</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($distribucion as $distribucion): ?>
                        <tr>
                            <td><?= $distribucion['iddis'] ?></td>
                            <td><?= $distribucion['descripcion'] ?></td>
                            <td width="200"><?= $distribucion['nombre'] ?></td>
                            <td><?= $distribucion['presentacion'] ?></td>
                            <td style="text-align: center;">
                                <button class="btn btn-warning btn-circle btn-sm">
                                <?= $distribucion['cantidad'] ?>
                                </button>
                            </td>
                            <td><?= $distribucion['fecha'] ?></td>
                            <td style="text-align: center;">
                                <a onclick="ver_medica(<?php echo $distribucion['iddis']; ?>)" href="" class="btn btn-primary btn-sm">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a  href="<?= Url::to(['distribucion/update', 'iddis' => $distribucion['iddis']]); ?>" class="btn btn-primary btn-sm">
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
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="distribuirMedicamentosLabel">Distribuir Medicamentos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row steps">
            <div class="col-sm-3 step">
                <button id="registro_pedido" class="btn btn-success btn-circle btn-lg active">
                    <i class="fas fa-file-alt"></i>
                </button>
                <p>1 - Registrar Pedido</p>
            </div>
            <div class="col-sm-3 step">
                <button id="registro_distribucion" class="btn btn-success btn-circle btn-lg">
                    <i class="fas fa-truck-loading"></i>
                </button>
                <p>2 - Distribución</p>
            </div>
        </div>

        <?= $this->render('../pedidos/create', [
        'model' => $model,
        ]) ?>

        <?= $this->render('create', [
        'model' => $model,
        ]) ?>
      </div>
      <div class="modal-footer"><!-- data-dismiss="modal" -->
        <button id="back" type="button" class="btn btn-secondary" >Atras</button>
        <button id="next" type="button" class="btn btn-primary">Siguiente</button>
        <a id="registrar_pedido_distribucion" href="#" class="btn btn-success btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-check"></i>
            </span>
            <span class="text">Guardar</span>
        </a>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal Distribuir Medicamentos -->

<?php
$script = <<< JS

      /* Botones - Pasos - Form */
      let registro_pedido = document.getElementById("registro_pedido");
      let registro_distribucion = document.getElementById("registro_distribucion");
      /*Fin Botones - Pasos - Form */

      let cont_distribucion = document.getElementById("distribucion");
      let cont_pedidos = document.getElementById("pedidos");
      let btn_next = document.getElementById("next");
      let btn_back = document.getElementById("back");
      let registrar_pedido_distribucion = document.getElementById("registrar_pedido_distribucion");

      //Modo Inicial - Default
      cont_distribucion.style.display = 'none';
      btn_back.style.visibility = 'hidden';
      document.getElementById("next").style.display = 'none';
      document.getElementById("registrar_pedido_distribucion").style.display = 'none';
      document.getElementById("pedido-sede").setAttribute('name', 'nombre_sede_pedido')
      document.getElementById('pedido-sede').previousElementSibling.innerHTML = 'Destino';
      document.getElementById('distribucion-idsede').previousElementSibling.innerHTML = 'Destino';
      //Fin Modo Inicial - Default

      btn_next.addEventListener("click", contDitribucion, false);

      function contDitribucion()
      {
        var pedido_idmedi      = document.getElementById("pedido-idmedi").value;
        var pedido_descripcion = document.getElementById("pedido-descripcion").value;
        var pedido_idsede      = document.getElementById("pedido-sede").value;
        var pedido_cantidad    = document.getElementById("pedido-cantidad").value;

        if(pedido_idmedi != "" && pedido_descripcion != "" && pedido_idsede != "" && pedido_cantidad != "")
        {
        
            cont_pedidos.style.display = 'none';
            cont_distribucion.style.display = 'block';

            registro_pedido.setAttribute('class', 'btn btn-success btn-circle btn-lg');
            registro_distribucion.setAttribute('class', 'btn btn-success btn-circle btn-lg active');
            btn_back.style.visibility = 'visible';
        }else{
            Swal.fire(
                   'Campo Vació',
                   'Rellena todos los campos',
                   'error'
            )
        }
      }

      btn_back.addEventListener("click", contPedidos, false);

      function contPedidos()
      {
        cont_distribucion.style.display = 'none';
        cont_pedidos.style.display = 'block';

        registro_distribucion.setAttribute('class', 'btn btn-success btn-circle btn-lg');
        registro_pedido.setAttribute('class', 'btn btn-success btn-circle btn-lg active');
        btn_back.style.visibility = 'hidden';
      }

      var idmedi      = document.getElementById("entradasmedicamentos-idmedi").value;
      //var descripcion = document.getElementById("distribucion-descripcion").value;
      var idsede      = document.getElementById("distribucion-idsede").value;
      var cantidad    = document.getElementById("distribucion-cantidad").value;
      var pedido_idmedi      = document.getElementById("pedido-idmedi").value;
      var pedido_descripcion = document.getElementById("pedido-descripcion").value;
      var pedido_idsede      = document.getElementById("pedido-sede").value;
      var pedido_cantidad    = document.getElementById("pedido-cantidad").value;
      
       

    function validationEventBlur(id)
    {
        var id = id;

        document.getElementById("pedido-cantidad").addEventListener('blur', validacion, false);

        function validacion()
        {
            var pedido_cantidad_f = document.getElementById("pedido-cantidad").value;

            if(pedido_cantidad_f != "")
            {
                var pedido_idmedi      = document.getElementById("pedido-idmedi").value;
                var pedido_descripcion = document.getElementById("pedido-descripcion").value;
                var pedido_idsede      = document.getElementById("pedido-sede").value;
                var pedido_cantidad    = document.getElementById("pedido-cantidad").value;

                if(pedido_idmedi != "" && pedido_descripcion != "" && pedido_idsede != "" && pedido_cantidad != "")
                {
                    document.getElementById("pedido-idmedi").style.borderColor = '#1cc88a';
                    document.getElementById("pedido-descripcion").style.borderColor = '#1cc88a';
                    document.getElementById("pedido-sede").style.borderColor = '#1cc88a';
                    document.getElementById("pedido-cantidad").style.borderColor = '#1cc88a';

                    
                    let nombre_medicamento = $('select[name="nombre_medicamento_pedido"] option:selected').text();

                    let nombre_sede = $('select[name="nombre_sede_pedido"] option:selected').text();

                    document.getElementById("entradasmedicamentos-idmedi").setAttribute('disabled', 'true');
                    document.getElementById("entradasmedicamentos-idmedi").innerHTML = '<option value="'+pedido_idmedi+'">'+ nombre_medicamento +'</option>';

                    document.getElementById("distribucion-idsede").setAttribute('disabled', 'true');
                    document.getElementById("distribucion-idsede").innerHTML = '<option value="'+pedido_idsede+'">'+ nombre_sede +'</option>';

                    document.getElementById("distribucion-cantidad").setAttribute('value', pedido_cantidad);
                    document.getElementById("distribucion-cantidad").setAttribute('disabled', 'true');


                    document.getElementById("next").style.display = 'block';
                    document.getElementById("pedido-cantidad").style.borderColor = '#1cc88a';
                }
            }
        }
    }

    function validationEventBlurSave(id)
    {
        var id = id;


        document.getElementById(id).addEventListener('blur', validacion, false);

        function validacion()
        {
            var idmedi      = document.getElementById("entradasmedicamentos-idmedi").value;
            var idsede      = document.getElementById("distribucion-idsede").value;
            var cantidad    = document.getElementById("distribucion-cantidad").value;
            var pedido_idmedi      = document.getElementById("pedido-idmedi").value;
            var pedido_descripcion = document.getElementById("pedido-descripcion").value;
            var pedido_idsede      = document.getElementById("pedido-sede").value;
            var pedido_cantidad    = document.getElementById("pedido-cantidad").value;
            var confirm_cantidad = document.getElementById("confirm-cantidad").value;


            if(pedido_idmedi != "" && pedido_descripcion != "" && pedido_idsede != "" && pedido_cantidad != "" && idmedi != "" && idsede != "" && cantidad != "")
            {
                if(pedido_cantidad === cantidad && confirm_cantidad === cantidad)
                {
                    next.style.display = 'none';
                    back.style.display = 'none';
                    registrar_pedido_distribucion.style.display = 'block';
                }else{
                    Swal.fire(
                   'Las unidades No Coinciden',
                   'Las unidades del Pedido no coinciden con las unidades de la distribución',
                   'error'
                  );

                  next.style.display = 'block';
                  back.style.display = 'block';
                  registrar_pedido_distribucion.style.display = 'none';
                }
            }
        }
    }

    

    validationEventBlur(pedido_cantidad);
    validationEventBlurSave('confirm-cantidad');
    
      
      //Registrar distribución de Medicamento
      //--------------------------------

    $("#registrar_pedido_distribucion").click(function(event) {

      var idmedi      = document.getElementById("entradasmedicamentos-idmedi").value;
      //var descripcion = document.getElementById("distribucion-descripcion").value;
      var idsede      = document.getElementById("distribucion-idsede").value;
      var cantidad    = document.getElementById("distribucion-cantidad").value;
      var pedido_idmedi      = document.getElementById("pedido-idmedi").value;
      var pedido_descripcion = document.getElementById("pedido-descripcion").value;
      var pedido_idsede      = document.getElementById("pedido-sede").value;
      var pedido_cantidad    = document.getElementById("pedido-cantidad").value;

      if(pedido_idmedi === "" && pedido_descripcion === "" && pedido_idsede === "" && pedido_cantidad === "" && idmedi === "" && idsede === "" && cantidad === "")
      {
        Swal.fire(
                   'Campo Vació',
                   'Rellena todos los campos',
                   'error'
        )

        return false
      }

      if(idmedi === pedido_idmedi && idsede === pedido_idsede && cantidad === pedido_cantidad)
      {
        event.preventDefault(); 
            
            var url = "sidmed.ve/index.php?r=distribucion/create";
            
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                            pedido_idmedi               : pedido_idmedi,
                            pedido_descripcion          : pedido_descripcion,
                            pedido_idsede               : pedido_idsede,
                            pedido_cantidad             : pedido_cantidad,
                            idmedi                      : idmedi,
                            //descripcion                 : descripcion,
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
                    );
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
      }else{
        Swal.fire(
                   'Pedido y Distribución No Coinciden',
                   'La informaión del pedido no coincide con la información suministrada en la distribución.',
                   'error'
        )
      }

            
    });

//Fin registrar distribución de Medicamento
//-------------------------------------
$("#pedido-idmedi").change(function(event) {

    let unidad = document.getElementById("pedido-idmedi").value;
    let cantidad_de_unidades = document.getElementById("cantidad_de_unidades");
    var url = "sidmed.ve/index.php?r=distribucion/filtrounidades";
        
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
//Fin Filtrar municipio mediante el estado (Filtro comunidad)
//-----------------------------------------------------------
//-----------------------------------------------------------
JS;
$this->registerJs($script);
?>