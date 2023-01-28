<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\DistribucionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Distribuciones';
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

<script>
    //Aprobar Distribución del Pedido
    //-------------------------------

    function aprobar(idpedi, id_orden)
    {
            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
            let data_idpedi      = idpedi;

            document.getElementById("aprobardistribucionLabel").innerHTML = "Responder Pedido N° "+ idpedi + id_orden +" ";
             
            document.getElementById("idpedi_dis").value = data_idpedi;

            $('#aprobardistribucion').modal({ show:true });
            document.querySelector(".preloader").style.display = 'none';   
    }

    //Aprobar Distribución del Pedido
    //-------------------------------

    //Modal ver Distribucion
    //----------------
    function view(id) 
    {
            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_iddis = id;

            $('#viewDistribucion').modal({ show:true });

            var url = window.location.protocol+"/index.php?r=distribucion/view";
    
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

//Modal ver Pedido
    //----------------
    function viewpedi(id) 
    {

            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_idpedi = id;

            $('#viewPedido').modal({ show:true });

            var url = window.location.protocol+"/index.php?r=distribucion/viewpedi";
    
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

                    document.getElementById("data_11").innerHTML = response.data.idpedi;
                    document.getElementById("data_22").innerHTML = response.data.id_orden;
                    document.getElementById("data_33").innerHTML = response.data.descripcion;
                    /*
                    document.getElementById("data_3").innerHTML = response.data.nombre;
                    document.getElementById("data_4").innerHTML = response.data.presentacion;
                    document.getElementById("data_5").innerHTML = response.data.cantidad;
                    */
                   
                    //console.log(response.data.medicamentos);

                    //tabla
                    var table = document.createElement("table");
                    table.setAttribute("class", "table table-bordered");
                    table.setAttribute("id", "table_items");
                    document.getElementById("table_medicamentos").appendChild(table);

                    //tr - title
                    var trtitle = document.createElement("tr");
                    table.appendChild(trtitle);

                    //th - nombre
                    var thtitlenombre = document.createElement("th");
                    thtitlenombre.innerHTML = "Nombre";
                    trtitle.appendChild(thtitlenombre);

                    //th - presentación
                    var thpresentacion = document.createElement("th");
                    thpresentacion.innerHTML = "Presentación";
                    trtitle.appendChild(thpresentacion);

                    //th - cantidad
                    var thtcantidad = document.createElement("th");
                    thtcantidad.setAttribute("style", "text-align:center;");
                    thtcantidad.innerHTML = "Cantidad";
                    trtitle.appendChild(thtcantidad);

                    


                    for (let index = 0; index < response.data.medicamentos.length; index++) {


                        //tr - Datos
                        var trdata = document.createElement("tr");
                        table.appendChild(trdata);

                        //td - nombre
                        var tdnombre = document.createElement("td");
                        tdnombre.innerHTML = response.data.medicamentos[index].nombre;
                        trdata.appendChild(tdnombre);

                        //td - presentacion
                        var tdpresentacion = document.createElement("td");
                        tdpresentacion.innerHTML = response.data.medicamentos[index].presentacion;
                        trdata.appendChild(tdpresentacion);

                        //td - cantidad
                        var tdcantidad = document.createElement("td");
                        tdcantidad.setAttribute("style", "text-align:center;");
                        tdcantidad.innerHTML = "<button class='btn btn-success'><strong>"+response.data.medicamentos[index].cantidad+"</strong></button>";
                        trdata.appendChild(tdcantidad);
                        

                    }

                    if(response.data.estatus === 1){
                        document.getElementById("data_44").innerHTML = '<button class="btn btn-primary btn-sm">Aprobado</button>';
                    }

                    if(response.data.estatus === 2){
                        document.getElementById("data_44").innerHTML = '<button class="btn btn-warning btn-sm">Pendiente</button>';
                    }

                    if(response.data.estatus === 3){
                        document.getElementById("data_44").innerHTML = '<button class="btn btn-danger btn-sm">Rechazado</button>';
                    }

                    document.getElementById("data_55").innerHTML = response.data.fecha;

                    document.getElementById("viewPedidoLabel").innerHTML = "Pedido "+ response.data.id_orden+ " ";

                }
            })
            .fail(function() {
                console.log("error");
            });
    }
    //Fin Modal ver Pedido
    //--------------------

    //Modal Modificar Distribucion
    //----------------------------
    function updateDis(id)
    {
            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_iddis = id;

            $('#actualizarDisttribucion').modal({ show:true });

            var url = window.location.protocol+"/index.php?r=distribucion/queryupdate";
    
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

    //Remover Medicamento de la Lista de Pedidos
    //------------------------------------------
    function removerMedicamento(id)
    {
        document.querySelector(".preloader").style.display = '';

        let input = document.getElementById(""+id+""); 
        let class_contenedor = "row contenedor_"+id;
        let id_contenedor    = "contenedor_"+id;
        let data_id_detalle_medi = input.getAttribute("data-id_detalle_medi");

        var url = window.location.protocol+"/index.php?r=distribucion/removermedicamento";

        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: {
                    data_id_detalle_medi       : data_id_detalle_medi,
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

                let contenedor_padre = document.getElementById(""+id_contenedor+"");
        
                contenedor_padre.remove();
                input.remove();
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

    }
    //Remover Medicamento de la Lista de Pedidos
    //------------------------------------------
</script>

<style>
    .dataTables_filter {
        float: right;
    }
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

    .close {
    padding: 1rem 1rem;
    margin: -1rem -1rem -1rem auto;
    display: none;
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
   
    <a class="btn btn-danger btn-sm" 
       title="Exportar Datos en Formato PDF" 
       href="<?= $url = Url::to(['distribucion/report']) ?>" 
       target="_blank">
        PDF <i class="far fa-file-pdf"></i>
    </a>

    <a class="btn btn-primary btn-sm" 
       title="Ver la lista de las distribuciones de medicamentos." 
       style="width: 5%;"
       href="<?= $url = Url::to(['distribucion/report']) ?>" 
       data-toggle="modal" 
       data-target="#modallistdistri">
        <i class="fas fa-table"></i>
    </a>

    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Orden</th>
                        <th>Destino</th>
                        <th>Estatus</th>
                        <th>Descripción</th>
                        <th>Fecha</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedidos): ?>
                        <tr>
                            <td><?= $pedidos['idpedi'] ?></td>
                            <td><?= $pedidos['id_orden'] ?></td>
                            <td><?= $pedidos['destino'] ?></td>
                            <td>
                                <?php
                                if($pedidos['estatus'] === 1)
                                {
                                    ?>
                                    <button class="btn btn-primary btn-sm">Aprobado</button>
                                    <?php
                                }
                                if($pedidos['estatus'] === 2)
                                {
                                    ?>
                                    <button class="btn btn-warning btn-sm">Pendiente</button>
                                    <?php
                                }
                                if($pedidos['estatus'] === 3)
                                {
                                    ?>
                                    <button class="btn btn-danger btn-sm">Rechazado</button>
                                    <?php
                                }
                                if($pedidos['estatus'] === 4)
                                {
                                    ?>
                                    <button class="btn btn-success btn-sm">Culminado</button>
                                    <?php
                                }
                                ?>
                            </td>
                            <td><?= ucwords($pedidos['descripcion']) ?></td>
                            <?php 
                                $dateString = $pedidos['fecha'];
                                $newDateString = date_format(date_create_from_format('Y-m-d', $dateString), 'd-m-Y');
                            ?>
                            <td><?= $newDateString ?></td>
                            <td style="text-align: center;">

                                <button title="Generar la distribución de este pedido" 
                                        class="btn btn-success btn-sm btn_distribuir"
                                        onclick="aprobar(<?= $pedidos['idpedi'] ?>, <?= $pedidos['id_orden'] ?>);">
                                    <i class="fas fa-check"></i>
                                </button>

                                <a onclick="viewpedi(<?php echo $pedidos['idpedi']; ?>)" title="Ver Registro" href="" class="btn btn-primary btn-sm">
                                    <i class="far fa-eye"></i>
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

<?= $this->render('modal_aprobar_distribuciones', [
        'model' => $model,
]) ?>

<?= $this->render('modal_lista_distribuciones', [
        'model' => $model,
]) ?>

<?= $this->render('modal_view_pedidos', [
        'model' => $model,
]) ?>


<!-- MODAL LISTADO DE DISTRIBUCIONES -->

<div class="modal fade" id="modallistdistri" tabindex="-1" aria-labelledby="modallistdistriLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modallistdistriLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="container-fluid">
            <h1 class="h3 mb-2 text-gray-800" style="margin-top: 20px;">Lista de Distribuciones</h1>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Entrega</th>
                                <th>Destino</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th style="text-align: center;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($distribuciones as $distribuciones): ?>
                                <tr>
                                    <td><?= $distribuciones['iddis'] ?></td>
                                    <td><?= $distribuciones['correlativo'] ?></td>
                                    </td>
                                    <td><?= $distribuciones['destino'] ?></td>
                                    <td><?= $distribuciones['descripcion'] ?></td>
                                    <?php 
                                    $dateString = $distribuciones['fecha'];
                                    $newDateString = date_format(date_create_from_format('Y-m-d', $dateString), 'd-m-Y');
                                    ?>
                                    <td><?= $newDateString ?></td>
                                    <td style="text-align: center;">

                                        <!--
                                        <a onclick="view(<?= $distribuciones['iddis']; ?>)" href="" class="btn btn-primary btn-sm">
                                            <i class="far fa-eye"></i>
                                        </a>
                                        <a onclick="updateRe(<?= $distribuciones['iddis']; ?>)" href="#" class="btn btn-primary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        -->

                                        <a title="Generar Orden de Entrega N° <?= $distribuciones['correlativo'] ?>" class="btn btn-danger btn-sm" href="<?= $url = Url::toRoute(['distribucion/notaentrega', 'id' => $distribuciones['iddis']]); ?>" target="_blank">
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
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- FIN MODAL LISTADO DE DISTRIBUCIONES -->

<?= $this->render('../site/preloader') ?>


<?php
$script = <<< JS

    $("#cerrar_modal_view").click(function() {
        document.getElementById("table_items").remove();
    });

    //Limpiar Datos temporales de la lista de pedidos

    window.addEventListener("load", function(event) {

        var url = window.location.protocol+"/index.php?r=distribucion/limpiardatostemporales";

        let parametro = 1;

        $.ajax({
        url: url,
        type: 'post',
        dataType: 'json',
        data: {
                    parametro : parametro,
        }
        })
        .done(function(response) {

        if (response.data.success == true) 
        {    
            /*
            document.querySelector(".preloader").style.display = 'none';
            Swal.fire(
            response.data.message,
            '',
            'success'
            );
            */

        }
        else
        {
            /*
            document.querySelector(".preloader").style.display = 'none';
            Swal.fire(
            response.data.message,
            '',
            'error'
            )
            */
        }

        })
        .fail(function() {
        console.log("error");
        });
    });

//Fin Limpiar Datos temporales de la lista de pedidos

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
            
            var url = window.location.protocol+"/index.php?r=distribucion/create";;
            
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
    
    var url = window.location.protocol+"/index.php?r=distribucion/responderpedido";
    
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

$('#dataTable2').dataTable( {
    "order": [[0,'DESC']]
} );
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


    var url = window.location.protocol+"/index.php?r=distribucion/update";

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


//Distribuir Pedido
//------------------
$("#distribuir_pedido").click(function(event) {

    document.querySelector(".preloader").setAttribute("style", "");
    event.preventDefault(); 

    var idpedi_dis           = document.getElementById("idpedi_dis").value;
    var descripcion_dis      = document.getElementById("descripcion_dis").value;

    var url = window.location.protocol+"/index.php?r=distribucion/aprobar";

    //Verificar validacion
    //---------------------
    var VerficarValidacion = 
    [
        validateNumber("idpedi_dis"),
        validateString("descripcion_dis"),
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
                    idpedi_dis                      : idpedi_dis, 
                    descripcion_dis                 : descripcion_dis,
        }
    })
    .done(function(response) {

        if (response.data.success == true) 
        {    
            document.querySelector(".preloader").style.display = 'none';
            Swal.fire(
            response.data.message,
            'La entrega se registro con el N° '+ response.data.correlativo +'',
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


//Fin Distribuir Pedido
//---------------------


//Filtrar canidad de medicamentos disponibles
//-------------------------------------------
$("#distribucion-idmedi").change(function(event) {
    document.querySelector(".preloader").setAttribute("style", "");
    let unidad = document.getElementById("distribucion-idmedi").value;
    let cantidad_de_unidades = document.getElementById("cantidad_de_unidades");
    var url = window.location.protocol+"/index.php?r=distribucion/filtrounidades";

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


$("#responder-idmedi").change(function(event) {

    let unidad = document.getElementById("responder-idmedi").value;
    let cantidad_de_unidades = document.getElementById("reponder_cantidad_de_unidades");
    var url = window.location.protocol+"/index.php?r=distribucion/filtrounidades";

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

 //Agregar Multiples medicamentos
   //------------------------------

   let add_medicine             = document.getElementById("add_medicine");
   let multiples_medicamentos   = document.getElementById("multiples-medicamentos");

   let contador = 0;  

   add_medicine.addEventListener('click', addMedicine, false);

   function addMedicine()
   {
        document.querySelector(".preloader").setAttribute("style", "");
        event.preventDefault();

        let pedido_idmedi = document.getElementById("distribucion-idmedi").value;
        let pedido_cantidad = document.getElementById("distribucion-cantidad").value;

        var url = window.location.protocol+"/index.php?r=distribucion/filtromedicamentos";

            //Verificar validacion
            //---------------------
            var VerficarValidacion = 
            [
                validateNumber("distribucion-idmedi"),
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

        $.ajax({
            url: url,
            type: 'post',
            dataType: 'json',
            data: {
                    pedido_idmedi       : pedido_idmedi,
                    pedido_cantidad     : pedido_cantidad
            }
        })
        .done(function(response) {
            if (response.data.success == true) 
            {
                contador = contador + 1;

                let class_contenedor = "row contenedor_"+contador;
                let id_contenedor    = "contenedor_"+contador;

                document.querySelector(".preloader").style.display = 'none';

                //Contenedor de los medicamentos agregados
                var cont_elemento = document.createElement("div");
                cont_elemento.setAttribute("class", class_contenedor);
                cont_elemento.setAttribute("id", id_contenedor);
                document.getElementById("multiples-medicamentos").appendChild(cont_elemento);

                //Columna que almacena el input
                var colum_input = document.createElement("div")
                colum_input.setAttribute("class","col-sm-10");
                cont_elemento.appendChild(colum_input);

                //Columna que almacena la cantidad
                var colum_cantidad = document.createElement("div")
                colum_cantidad.setAttribute("class","col-sm-1");
                cont_elemento.appendChild(colum_cantidad);

                //Boton con la cantidad
                var btn_cantidad = document.createElement("button")
                btn_cantidad.setAttribute("class","btn btn-success btn-sm");
                btn_cantidad.setAttribute("style","width:100%;");
                colum_cantidad.appendChild(btn_cantidad);
                btn_cantidad.innerHTML = pedido_cantidad;

                //Columna que almacena el boton borrar
                var colum_btn_delete = document.createElement("div")
                colum_btn_delete.setAttribute("class","col-sm-1");
                cont_elemento.appendChild(colum_btn_delete);
                
                //Boton borrar
                var btn_delete = document.createElement("button")
                btn_delete.setAttribute("class","btn btn-danger btn-sm");
                btn_delete.setAttribute("title","Remover Medicamento");
                btn_delete.setAttribute("type","button");
                btn_delete.setAttribute("onclick","removerMedicamento("+contador+")");
                btn_delete.setAttribute("style","width:100%;");
                colum_btn_delete.appendChild(btn_delete);

                //Icono del boton borrar
                var icono_btn_delete = document.createElement("i")
                icono_btn_delete.setAttribute("class","fas fa-trash");
                icono_btn_delete.setAttribute("data-id", response.data.id_detalle_medi);
                btn_delete.appendChild(icono_btn_delete);

                var newInput = document.createElement("input");
                newInput.setAttribute("type","text");
                newInput.setAttribute("class","form-control input-medicamento");
                newInput.setAttribute("disabled","");
                newInput.setAttribute("data-id_detalle_medi", response.data.id_detalle_medi);
                newInput.setAttribute("data-idtipo", response.data.idtipo);
                newInput.setAttribute("data-cantidad", pedido_cantidad);
                newInput.setAttribute("style","margin-bottom:10px;");
                newInput.setAttribute("id", contador);
                colum_input.appendChild(newInput);

                document.getElementById(contador).setAttribute("value", response.data.nombre+' '+response.data.presentacion);
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

        //multiples_medicamentos.innerHTML = '<div class="row"><div class="col-sm-4"><input id="" class="form-control" disabled type="text" value="Acetaminofen"></div> <div class="col-sm-4"><button title="Remover Medicamento" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button></div></div>';
   }

   //Fin Agregar Multiples medicamentos
   //----------------------------------
JS;
$this->registerJs($script);
?>