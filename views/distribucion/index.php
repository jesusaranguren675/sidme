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

    <a class="btn btn-primary btn-sm" title="Agregar una Distribución"  href="<?= Url::toRoute('entradasmedicamentos/create'); ?> " data-toggle="modal" data-target="#distribuirMedicamentos">
        Agregar <i class="fas fa-plus"></i>
    </a>
   
    <a class="btn btn-danger btn-sm" title="Exportar Datos en Formato PDF" href="<?= $url = Url::to(['distribucion/report']) ?>" target="_blank">
        PDF <i class="far fa-file-pdf"></i>
    </a>

    <a class="btn btn-danger btn-sm" title="Responder Pedido" href="<?= $url = Url::to(['distribucion/report']) ?>" target="_blank">
        PEDIDO <i class="fas fa-file-signature"></i></i>
    </a>

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
                <tbody>
                    <?php foreach ($distribucion as $distribucion): ?>
                        <tr>
                            <td><?= $distribucion['iddis'] ?></td>
                            <td><?= $distribucion['descripcion'] ?></td>
                            <td width="200"><?= $distribucion['nombre'] ?></td>
                            <td><?= $distribucion['presentacion'] ?></td>
                            <td style="text-align: center;">
                                <button class="btn btn-warning btn-sm">
                                <?= $distribucion['cantidad'] ?>
                                </button>
                            </td>
                            <?php 
                                $dateString = $distribucion['fecha'];
                                $newDateString = date_format(date_create_from_format('Y-m-d', $dateString), 'd-m-Y');
                            ?>
                            <td><?= $newDateString ?></td>
                            <td style="text-align: center;">
                                <a onclick="ver_medica(<?php echo $distribucion['iddis']; ?>)" title="Ver Registro" href="" class="btn btn-primary btn-sm">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a  href="<?= Url::to(['distribucion/update', 'iddis' => $distribucion['iddis']]); ?>" title="Modificar Registro" class="btn btn-primary btn-sm">
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

<?= $this->render('modal_registrar_distribucion', [
        'model' => $model,
]) ?>

<?= $this->render('../site/preloader') ?>


<?php
$script = <<< JS

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
            
            var url = "sidmed.ve/index.php?r=distribucion/create";
            
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
//-------------------------------------



//Filtrar canidad de medicamentos disponibles
   //-------------------------------------------
   $("#distribucion-idmedi").change(function(event) {

let unidad = document.getElementById("distribucion-idmedi").value;
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