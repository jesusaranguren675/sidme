<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
$medicamento = \app\models\Tipomedicamento::find()->all();
$sedes = \app\models\Sede::find()->all();

$medicamentos = 
Yii::$app->db->createCommand("SELECT
detalle_medi.id_detalle_medi,
medicamentos.nombre, 
tipo_medicamento.descripcion
FROM detalle_medi AS detalle_medi
JOIN medicamentos AS medicamentos
ON medicamentos.idmedi=detalle_medi.idmedi
JOIN tipo_medicamento AS tipo_medicamento
ON detalle_medi.idtipo=tipo_medicamento.idtipo")->queryAll();
/* @var $this yii\web\View */
/* @var $model app\models\Entradasmedicamentos */
/* @var $form yii\widgets\ActiveForm */

/* @var $this yii\web\View */
/* @var $model app\models\Distribucion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="distribucion-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-4">
            <label for="entradasmedicamentos-idmedi">Medicamento</label>
            <select class="form-control" id="entradasmedicamentos-idmedi">
                <?php foreach ($medicamentos as $medicamentos): ?>
                    <option value="<?= $medicamentos['id_detalle_medi'] ?>"><?= $medicamentos['nombre'] ?> <?= $medicamentos['descripcion'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-sm-4">
            <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>
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
      
      //Registrar distribución de Medicamento
      //--------------------------------

      $("#distribuir_medicamento").click(function(event) {

            event.preventDefault(); 
            
            var idmedi      = document.getElementById("entradasmedicamentos-idmedi").value;
            var descripcion = document.getElementById("distribucion-descripcion").value;
            var idsede      = document.getElementById("distribucion-idsede").value;
            var cantidad    = document.getElementById("distribucion-cantidad").value;
            
            
    
            //Contiene la ruta del controlador que procesara los datos enviados mediante el formulario
            //Debemos tomar en cuenta que esta ruta la obtenemos del atributo action que corresponde al formulario
            //-----------------------------------------------------------------------------------------

            //var url = document.getElementById("w0").getAttribute("action");

            var url = "sidmed.ve/index.php?r=distribucion/create";
            
            $.ajax({
                url: url,
                type: 'post',
                dataType: 'json',
                data: {
                            idmedi                      : idmedi,
                            descripcion                 : descripcion,
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

         //Fin registrar distribución de Medicamento
        //-------------------------------------
JS;
$this->registerJs($script);
?>