<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\assets\SweetalertAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Medialmaxpre */
/* @var $form yii\widgets\ActiveForm */

$presentaciones = \app\models\Presentaciones::find()->all();
$procedencias = \app\models\Procedencias::find()->all();
$tiposprocedencia = \app\models\Tiposprocedencia::find()->all();
?>

<!-- Basic Card Example -->
<div class="card shadow mb-4">
    <!--
    <div class="card-header py-3">
        <h4 class="m-0 font-weight-bold text-primary"><?= Html::encode($this->title) ?></h4>
    </div>
    -->
    <div class="card-body">
    <div class="medialmaxpre-form">
        <?php $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'enableAjaxValidation' => false,
        ]); ?>

        <div class="row">
            <div class="col-sm-6">
                <?= $form->field($model, 'nombre_medicamento_almacen')->textInput() ?>
            </div>

            <div class="col-sm-6">
                <?= $form->field($model, "id_presentacion")->dropDownList(
                            ArrayHelper::map($presentaciones, 'id_presentacion', 'nombre_presentacion'),
                            ['prompt' => 'Seleccione']);?>
            </div>

            <div class="col-sm-6">
            <?= $form->field($model, "id_tipo_procedencia")->dropDownList(
                            ArrayHelper::map($tiposprocedencia, 'id_tipo_procedencia', 'nombre_tipo_procedencia'),
                            ['prompt' => 'Seleccione']);?>
            </div>

            <div class="col-sm-6">
            <?= $form->field($model, "id_procedencia")->dropDownList(
                            ArrayHelper::map($procedencias, 'id_procedencia', 'nombre_procedencia'),
                            ['prompt' => 'Seleccione']);?>
            </div>

            <div class="col-sm-6">
                <?= $form->field($model, 'stock')->textInput() ?>
            </div>
        </div>

        <!--
        <div class="form-group">
            <button id="registrar_medicamento" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
        </div>
        -->

        <?php ActiveForm::end(); ?>

</div>

     </div>
</div>


<?php
$script = <<< JS

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

            var url = document.getElementById("w0").getAttribute("action");

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
