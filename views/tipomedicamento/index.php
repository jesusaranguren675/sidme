<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TipomedicamentoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Presentaciones';
$this->params['breadcrumbs'][] = $this->title;
?>

<script>
        //Modal Modificar Pedido
    //----------------------
    function updatePre(id)
    {
            event.preventDefault();

            document.querySelector(".preloader").style.display = '';
    
            let data_idtipo = id;

            $('#actualizarPre').modal({ show:true });

            /*
            var url = "http://sidmed.ve/index.php?r=tipo_medicamento/queryupdate";
    
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                    data_idtipo : data_idtipo
                }
            })
            .done(function(response) {
                if (response.data.success == true) 
                {
                    document.querySelector(".preloader").style.display = 'none';
                    
                    document.getElementById("pedido-descripcion-update").setAttribute("value", response.data.descripcion);
                    document.getElementById("pedido-cantidad-update").setAttribute("value", response.data.cantidad);
                    document.getElementById("idpedi-update").setAttribute("value", response.data.idpedi);


                    //document.getElementById("viewPedidoLabel").innerHTML = response.data.nombre+ " " + response.data.presentacion;
                }
            })
            .fail(function() {
                console.log("error");
            });
            */
    }
    //Fin Modificar Modal ver Pedido
    //------------------------------
</script>

<div class="card shadow mb-4">
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800" style="margin-top: 20px;"><?= Html::encode($this->title) ?></h1>
        <hr>
        <a class="btn btn-primary btn-sm"  href="#" data-toggle="modal" data-target="#modalPresentacion">
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
                        <th>Nombre</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $contador = 1; ?>
                    <?php foreach ($presentaciones as $presentaciones): ?>
                        <tr>
                            <td><?= $contador ?></td>
                            <td><?= $presentaciones['descripcion'] ?></td>
                            <td style="text-align: center;">
                                <a onclick="view(<?php echo $presentaciones['idtipo']; ?>)" id="view_<?php echo $presentaciones['idtipo']; ?>"
                                   data-idpedi="<?php echo $presentaciones['idtipo']; ?>" 
                                   href="" 
                                   class="btn btn-primary btn-sm view_btn">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a onclick="updatePre(<?php echo $presentaciones['idtipo']; ?>)"
                                   href="#" 
                                   class="btn btn-primary btn-sm update_btn">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        <?php $contador = $contador + 1; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->render('modal_registrar_presentacion', [
        'model' => $model,
]) ?>

<?= $this->render('modal_registrar_presentacion', [
        'model' => $model,
]) ?>

<?= $this->render('../site/preloader') ?>


<?php
$script = <<< JS

    var descripcion = document.getElementById("tipomedicamento-descripcion").value;

    validateStringBlur("tipomedicamento-descripcion");

    //Registrar Presentación del Medicamento
    //--------------------------------------

    $("#registrar_presentacion").click(function(event) {
    
        document.querySelector(".preloader").setAttribute("style", "");
        event.preventDefault(); 

        var descripcion             = document.getElementById("tipomedicamento-descripcion").value;

        var url = "http://sidmed.ve/index.php?r=tipomedicamento/create";

            //Verificar validacion
            //---------------------
            var VerficarValidacion = 
            [
                validateString("tipomedicamento-descripcion"),
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

    //Fin registrar Presentación del Medicamento
   //-------------------------------------------
JS;
$this->registerJs($script);
?>
