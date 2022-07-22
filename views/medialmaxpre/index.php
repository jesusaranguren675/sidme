<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
use app\assets\DatatableAsset;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MedialmaxpreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
DatatableAsset::register($this);
$this->title = Yii::t('app', 'Medicamentos del Almacen');
$this->params['breadcrumbs'][] = $this->title;
?>







    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="container-fluid">
            <br>
             <!-- Page Heading -->
             <h1 class="h3 mb-2 text-gray-800">Medicamentos del Almacen</h1>
             <hr class="sidebar-divider">
            <!--<p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
                                For more information about DataTables, please visit the <a target="_blank"
                                    href="https://datatables.net">official DataTables documentation</a>.</p>-->
                <p>
                
                <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" href="<?= Url::toRoute('medialmaxpre/create'); ?>"><i class="fas fa-plus"></i> Agregar</a>

                <a class="btn btn-danger btn-sm" href="<?= Url::toRoute('medialmaxpre/create'); ?>" target="_blank"><i class="fas fa-file-pdf"></i> pdf</a>
                <button class="btn btn-success btn-sm" href="<?= Url::toRoute('medialmaxpre/create'); ?>"><i class="fas fa-file-excel"></i> excel</button>
            </p>
        </div>
        <!--<div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>-->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>N°</th>
                                            <th>Medicamento</th>
                                            <th>Presentacion</th>
                                            <th>Entrada</th>
                                            <th>Salida</th>
                                            <th>Existencia</th>
                                            <th style="text-align: center;">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>N°</th>
                                            <th>Medicamento</th>
                                            <th>Presentacion</th>
                                            <th>Entrada</th>
                                            <th>Salida</th>
                                            <th>Existencia</th>
                                            <th style="text-align: center;">Acciones</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                    <?php foreach ($almacen as $almacen): ?>
                                        <tr>
                                            <td><?= $almacen['id_medi_alma_x_pre'] ?></td>
                                            <td><?= $almacen['nombre_medicamento_almacen'] ?></td>
                                            <td><?= $almacen['nombre_presentacion'] ?></td>
                                            <td><?= $almacen['entrada'] ?></td>
                                            <td>
                                                <?php
                                                if(empty($almacen['salida']))
                                                {
                                                    echo 0;
                                                }else{
                                                    echo $almacen['salida'];
                                                }
                                                ?>
                                            </td>
                                            <td><?= $almacen['existencia'] ?></td>
                                            <td style="text-align: center;">
                                                <a href="<?= Url::to(['medialmaxpre/view', 'id_medi_alma_x_pre' => $almacen['id_medi_alma_x_pre']]); ?>" class="btn btn-primary btn-sm"><i class="fas fa-eye"></i></a>
                                                <a href="<?= Url::to(['medialmaxpre/update', 'id_medi_alma_x_pre' => $almacen['id_medi_alma_x_pre']]); ?>" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
    </div>



<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <div style="border-bottom: none;" class="card-header py-3">
            <h4 class="m-0 font-weight-bold text-primary"><?= Html::encode($this->title) ?></h4>
        </div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <?= $this->render('_form', [
            'model' => $model,
            ]) ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="registrar_medicamento" type="button" class="btn btn-primary"><i class="fas fa-save"></i>
            Guardar</button>
      </div>
    </div>
  </div>
</div>

<?php
$script = <<< JS
    
    console.log(document.getElementById("w0").getAttribute("action"));
      //Registrar Medicamento
      /////////////////////
      var procedencia = document.getElementById("medialmaxpre-id_procedencia");
      procedencia.innerHTML = '<option value="">Seleccione</option>';

      $("#registrar_medicamento").click(function(event) {

            //document.querySelector(".preloader").setAttribute("style", "");
            event.preventDefault();             

            var nombre_medicamento_almacen = document.getElementById("medialmaxpre-nombre_medicamento_almacen").value;
            var medialmaxpre_id_presentacion = document.getElementById("medialmaxpre-id_presentacion").value;
            var medialmaxpre_id_procedencia = document.getElementById("medialmaxpre-id_procedencia").value;
            var medialmaxpre_stock = document.getElementById("medialmaxpre-stock").value;
          

            //Contiene la ruta del controlador que procesara los datos enviados mediante el formulario
            //Debemos tomar en cuenta que esta ruta la obtenemos del atributo action que corresponde al formulario
            //-----------------------------------------------------------------------------------------

            //var url = document.getElementById("w0").getAttribute("action");

            var url = "/index.php?r=medialmaxpre%2Fcreate";

            console.log(url);

            //Verificar validacion
            //---------------------
            
            if(nombre_medicamento_almacen == "" || medialmaxpre_id_presentacion == "" || medialmaxpre_stock == "")
            {
                Swal.fire(
                   'Completa los campos requeridos',
                   '',
                   'error'
                )

                return false;
            }
        
         $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                            nombre_medicamento_almacen     : nombre_medicamento_almacen,
                            medialmaxpre_id_presentacion   : medialmaxpre_id_presentacion,
                            medialmaxpre_id_procedencia    : medialmaxpre_id_procedencia,
                            medialmaxpre_stock             : medialmaxpre_stock,
                }
            })
            .done(function(response) {

                if(response.data.validation)
                {
                   Swal.fire(
                   response.data.message,
                   '',
                   'error'
                   )

                   return;
                }
                else
                {
                    if (response.data.success == true) 
                    {
                        Swal.fire(
                        response.data.message,
                        '<a href="http://localhost/sidmed/web/index.php?r=medialmaxpre%2Fview&id_medi_alma_x_pre='+response.data.id+'">Visualizar el medicamento agregado',
                        'success'
                        )
                    }
                    else
                    {
                        Swal.fire(
                        response.data.message,
                        'Exito',
                        'error'
                        )
                    }
                }
                
             
            })
            .fail(function() {
                console.log("error");
            });
     });

     //Fin registrar Medicamento
     ///////////////////////////

     //Filtrar procedencia
     /////////////////////
     

      $("#medialmaxpre-id_tipo_procedencia").change(function(event) {
            
            var tipo_procedencia = $("#medialmaxpre-id_tipo_procedencia").val();
            
            var url = "http://sidmed.ve/index.php?r=medialmaxpre/filtroprocedencia";
        
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                    tipo_procedencia                : tipo_procedencia
                }
            })
            .done(function(response) {

                if (response.data.success == true) 
                {
                    //Limpiar select de municipios
                    procedencia.innerHTML = '<option value="">Seleccione</option>';


                    for (es = 0; es < response.data.procedencia.length; es++)
                    {
                            //Crea el elemento <option> dentro del select municipio
                            var itemOption = document.createElement('option');

                            //Contenido de los <option> del select municipios
                            var nombre_procedencia = document.createTextNode(response.data.procedencia[es].nombre_procedencia); 
                            var id_procedencia = document.createTextNode(response.data.procedencia[es].id_procedencia); 
                        
                            //Crear atributo value para los elemento option
                            var attValue = document.createAttribute("value");
                            attValue.value = response.data.procedencia[es].id_procedencia;
                            itemOption.setAttributeNode(attValue);


                            //Añadir contenido a los <option> creados 
                            itemOption.appendChild(nombre_procedencia);
                         
                            document.getElementById("medialmaxpre-id_procedencia").appendChild(itemOption);


                    }
                }
             
            })
            .fail(function() {
                console.log("error");
            });
        });

        //Fin Filtrar procedencia
        /////////////////////////
JS;
$this->registerJs($script);
?>


            
