<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
$medicamentos = \app\models\Medicamentos::find()->all();
$tipo_medicamento = \app\models\Tipomedicamento::find()->all();
$sedes = \app\models\Sede::find()->all();
/* @var $this yii\web\View */
/* @var $model app\models\Entradasmedicamentos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entradasmedicamentos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
            <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>
        </div>

        <div class="col-sm-4">
            <?= $form->field($model, "idmedi")->dropDownList(
                             ArrayHelper::map($medicamentos, 'idmedi', 'nombre'),
                             ['prompt' => 'Seleccione']);?>  
        </div>

        <div class="col-sm-4">
            <?= $form->field($model, "idtipo")->dropDownList(
                             ArrayHelper::map($tipo_medicamento, 'idtipo', 'descripcion'),
                             ['prompt' => 'Seleccione']);?>  
        </div>

        <div class="col-sm-4">
            <?= $form->field($model, "idsede")->dropDownList(
                             ArrayHelper::map($sedes, 'idsede', 'nombre'),
                             ['prompt' => 'Seleccione']);?>  
        </div>

        <div class="col-sm-4">
            <?= $form->field($model, 'cantidad')->textInput(['maxlength' => true, 'type' => 'number']) ?>
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>

<?php
$script = <<< JS
      
      //Registrar Ingreso de Medicamento
      //--------------------------------

      $("#registrar_medicamento").click(function(event) {

            event.preventDefault(); 
            
            var descripcion = document.getElementById("entradasmedicamentos-descripcion").value;
            var idmedi      = document.getElementById("entradasmedicamentos-idmedi").value;
            var idtipo      = document.getElementById("entradasmedicamentos-idtipo").value;
            var idsede      = document.getElementById("entradasmedicamentos-idsede").value;
            var cantidad    = document.getElementById("entradasmedicamentos-cantidad").value;
            
            
    
            //Contiene la ruta del controlador que procesara los datos enviados mediante el formulario
            //Debemos tomar en cuenta que esta ruta la obtenemos del atributo action que corresponde al formulario
            //-----------------------------------------------------------------------------------------

            //var url = document.getElementById("w0").getAttribute("action");

            var url = "sidmed.ve/index.php?r=entradasmedicamentos/create";
            
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                            descripcion                 : descripcion,
                            idmedi                      : idmedi,
                            idtipo                      : idtipo,
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
                    )
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
        });

         //Fin registrar Ingreso de Medicamento
        //-------------------------------------
JS;
$this->registerJs($script);
?>