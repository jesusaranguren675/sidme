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
    //Modal ver Pedido
    //----------------
    function view(id) 
    {

            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_idpedi = id;

            $('#viewPedido').modal({ show:true });

            var url = window.location.protocol+"/index.php?r=pedidos/view";
    
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
                    document.getElementById("data_2").innerHTML = response.data.id_orden;
                    document.getElementById("data_3").innerHTML = response.data.descripcion;
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
                        document.getElementById("data_4").innerHTML = '<button class="btn btn-primary btn-sm">Aprobado</button>';
                    }

                    if(response.data.estatus === 2){
                        document.getElementById("data_4").innerHTML = '<button class="btn btn-warning btn-sm">Pendiente</button>';
                    }

                    if(response.data.estatus === 3){
                        document.getElementById("data_4").innerHTML = '<button class="btn btn-danger btn-sm">Rechazado</button>';
                    }

                    document.getElementById("data_5").innerHTML = response.data.fecha;

                    document.getElementById("viewPedidoLabel").innerHTML = "Pedido "+ response.data.id_orden+ " ";

                }
            })
            .fail(function() {
                console.log("error");
            });
    //Fin Modal ver Pedido
    //--------------------
    }

    //Modal Modificar Pedido
    //----------------------
    function updatePedi(id)
    {
            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_idpedi = id;

            $('#actualizarMedicamentos').modal({ show:true });

            var url = window.location.protocol+"/index.php?r=pedidos/queryupdate";
    
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
                    
                    document.getElementById("pedido-descripcion-update").setAttribute("value", response.data.descripcion);
                    //document.getElementById("pedido-cantidad-update").setAttribute("value", response.data.cantidad);
                    document.getElementById("idpedi-update").setAttribute("value", response.data.idpedi);
                    document.getElementById("destino_name_id_update").setAttribute("value", response.data.destino);

                    let destino = response.data.destino;


                    //document.getElementById("viewPedidoLabel").innerHTML = response.data.nombre+ " " + response.data.presentacion;
                }
            })
            .fail(function() {
                console.log("error");
            });
    }
    //Fin Modificar Modal ver Pedido
    //------------------------------


    //Remover Medicamento de la Lista de Pedidos
    //------------------------------------------
    function removerMedicamento(id)
    {
        document.querySelector(".preloader").style.display = '';

        let input = document.getElementById(""+id+""); 
        let class_contenedor = "row contenedor_"+id;
        let id_contenedor    = "contenedor_"+id;
        let data_id_detalle_medi = input.getAttribute("data-id_detalle_medi");

        var url = window.location.protocol+"/index.php?r=pedidos/removermedicamento";

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
        <a class="btn btn-primary btn-sm"  href="<?= Url::toRoute('entradasmedicamentos/create'); ?> " data-toggle="modal" data-target="#distribuirMedicamentos">
        Agregar <i class="fas fa-plus"></i>
        </a>
        <a class="btn btn-danger btn-sm" href="<?= $url = Url::to(['pedidos/report']) ?>" target="_blank">
            PDF <i class="far fa-file-pdf"></i>
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered dataTable" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Orden</th>
                        <th>Descripción</th>
                        <!--<th>Nombre</th>-->
                        <!--<th>Presentación</th>-->
                        <th>Destino</th>
                        <!--<th>Cantidad</th>-->
                        <th>Estatus</th>
                        <th>Fecha</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $contador = 1; ?>
                    <?php foreach ($pedidos as $pedidos): ?>
                        <tr>
                            <td><?= $contador ?></td>
                            <td><?= $pedidos['id_orden'] ?></td>
                            <td><?= ucwords($pedidos['descripcion']) ?></td>
                            <!--<td width="100"><?= $pedidos['nombre'] ?></td>-->
                            <!--<td><?= $pedidos['presentacion'] ?></td>-->
                            <td width="100"><?= $pedidos['procedencia'] ?></td>
                            <!--
                            <td style="text-align: center;">
                                <button class="btn btn-success btn-sm">
                                <?= $pedidos['cantidad'] ?>
                                </button>
                            </td>
                            -->
                            <td style="text-align: center;">
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
                            <?php 
                                $dateString = $pedidos['fecha'];
                                $newDateString = date_format(date_create_from_format('Y-m-d', $dateString), 'd-m-Y');
                            ?>
                            <td><?= $newDateString ?></td>
            
                            <td style="text-align: center;">
                                <a onclick="view(<?php echo $pedidos['idpedi']; ?>)" id="view_<?php echo $pedidos['idpedi']; ?>"
                                   data-idpedi="<?php echo $pedidos['idpedi']; ?>" 
                                   href="" 
                                   class="btn btn-primary btn-sm view_btn">
                                    <i class="far fa-eye"></i>
                                </a>
                                
                                <?php
                                   if($rol == 'Empleado')
                                   {
                                       
                                   }
                                   else if($rol == 'Administrador')
                                   {
                                        if($pedidos['estatus'] === 4 || $pedidos['estatus'] === 3)
                                        {
                                            
                                        }
                                        else
                                        {
                                            ?>
                                            <a onclick="updatePedi(<?php echo $pedidos['idpedi']; ?>)"
                                            href="#" 
                                            class="btn btn-primary btn-sm update_btn">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <?php
                                        }
                                   }
                                ?>

                                <?php
                                    if($pedidos['estatus'] === 3)
                                    {

                                    }
                                    else{
                                        ?>
                                        <a title="Generar Orden del Pedido N° <?= $pedidos['id_orden'] ?>" class="btn btn-danger btn-sm" href="<?= $url = Url::toRoute(['pedidos/notaentrega', 'id' => $pedidos['idpedi']]); ?>" target="_blank">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                        <?php
                                    }
                                ?>
                            </td>
                        </tr>
                        <?php $contador = $contador + 1; ?>
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

    //Remover Table de la vista
    //-------------------------

    

    $("#cerrar_modal_view").click(function() {
        document.getElementById("table_items").remove();
    });

//Limpiar Datos temporales de la lista de pedidos

    

    window.addEventListener("load", function(event) {

        var url = window.location.protocol+"/index.php?r=pedidos/limpiardatostemporales";

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

$(document).ready(function() {
    $('.js-example-basic-single').select2({
        dropdownParent: $('#distribuirMedicamentos .modal-body'),
    });

    $('#pedido-idmedi-update').select2({
        dropdownParent: $('#actualizarMedicamentos .modal-body'),
    });

    $('#pedido-sede-update').select2({
        dropdownParent: $('#actualizarMedicamentos .modal-body'),
    });

    $('#pedido-estatus-update').select2({
        dropdownParent: $('#actualizarMedicamentos .modal-body'),
    });


});

    var descripcion             = document.getElementById("pedido-descripcion").value;
    var idmedi                  = document.getElementById("pedido-idmedi").value;
    var procedencia             = document.getElementById("pedido-sede").value;
    var cantidad                = document.getElementById("pedido-cantidad").value;
    var cantidad_de_unidades    = document.getElementById("cantidad_de_unidades");
    //var estatus                 = document.getElementById("pedido-estatus").value;

    validateStringBlur("pedido-descripcion");
    validateNumberBlur("pedido-idmedi");
    validateNumberBlur("pedido-sede");
    validateNumberBlur("pedido-cantidad");
    //validateNumberBlur("pedido-estatus");
    
    document.getElementById('pedido-sede').previousElementSibling.innerHTML = 'Procedencia';


     //Registrar Pedido de Medicamento
    //--------------------------------

    $("#registrar_pedido").click(function(event) {
    
        document.querySelector(".preloader").setAttribute("style", "");
        event.preventDefault(); 

        let input_medicamento = document.querySelectorAll(".input-medicamento");

        var descripcion             = document.getElementById("pedido-descripcion").value;
        var idmedi                  = document.getElementById("pedido-idmedi").value;
        var procedencia             = document.getElementById("pedido-sede").value;
        var cantidad                = document.getElementById("pedido-cantidad").value;
        var cantidad_de_unidades    = document.getElementById("cantidad_de_unidades");
        //var estatus                 = document.getElementById("pedido-estatus").value;
        var url = window.location.protocol+"/index.php?r=pedidos/create";

            //Verificar validacion
            //---------------------
            var VerficarValidacion = 
            [
                validateString("pedido-descripcion"),
                validateNumber("pedido-idmedi"),
                validateNumber("pedido-sede"),
                validateNumber("pedido-cantidad"),
                //validateNumber("pedido-estatus"),
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
                      //estatus                   : estatus,

          }
      })
      .done(function(response) {

          if (response.data.success == true) 
          {    
              document.querySelector(".preloader").style.display = 'none';
              Swal.fire(
              response.data.message,
              'El pedido se registro con el N° de Orden '+ response.data.id_orden +'',
              'success'
              );

            $('#distribuirMedicamentos').modal('hide')
              
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

    //Fin registrar Pedido de Medicamento
   //-------------------------------------------

   //Actualizar Pedido de Medicamento
   //--------------------------------
   $("#modificar_pedido").click(function(event) {

        document.querySelector(".preloader").setAttribute("style", "");
        event.preventDefault(); 

        var idpedi_update                = document.getElementById("idpedi-update").value;
        var pedido_descripcion_update    = document.getElementById("pedido-descripcion-update").value;
        //var pedido_idmedi_update         = document.getElementById("pedido-idmedi-update").value;
        var pedido_sede_update           = document.getElementById("pedido-sede-update").value;
        //var pedido_cantidad_update       = document.getElementById("pedido-cantidad-update").value;
        var pedido_estatus_update        = document.getElementById("pedido-estatus-update").value;

        var url = window.location.protocol+"/index.php?r=pedidos/update";

        //Verificar validacion
        //---------------------
        var VerficarValidacion = 
        [
            validateString("pedido-descripcion-update"),
            //validateNumber("pedido-idmedi-update"),
            validateNumber("pedido-sede-update"),
            //validateNumber("pedido-cantidad-update"),
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
                        //pedido_idmedi_update          : pedido_idmedi_update,
                        pedido_sede_update            : pedido_sede_update,
                        //pedido_cantidad_update        : pedido_cantidad_update,
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

   //Fin Actualizar Pedido de Medicamento
   //------------------------------------


   //Filtrar canidad de medicamentos disponibles
   //-------------------------------------------
   $("#pedido-idmedi").change(function(event) {

        let unidad = document.getElementById("pedido-idmedi").value;
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
        })
        .fail(function() {
            console.log("error");
        });
    });

    $("#pedido-idmedi-update").change(function(event) {

        let unidad = document.getElementById("pedido-idmedi-update").value;
        let cantidad_de_unidades = document.getElementById("cantidad_de_unidades_update");
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

        let pedido_idmedi = document.getElementById("pedido-idmedi").value;
        let pedido_cantidad = document.getElementById("pedido-cantidad").value;

        var url = window.location.protocol+"/index.php?r=pedidos/filtromedicamentos";

        //Verificar validacion
        //---------------------
        var VerficarValidacion = 
        [
            validateNumber("pedido-idmedi"),
            validateNumber("pedido-cantidad"),
        ];

        for (ver = 0; ver < VerficarValidacion.length; ver++) {
            if(VerficarValidacion[ver] === false)
            {
                document.querySelector(".preloader").style.display = 'none';
                event.preventDefault();
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
