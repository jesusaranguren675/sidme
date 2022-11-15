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

<div class="distribucion-form" id="distribucion">
    Distribución
    <hr>
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'enableAjaxValidation' => false,
    ]); ?>

    <div class="row">
        <!--
        <div class="col-sm-6">
            <?php /* $form->field($model, 'descripcion')->textInput(['maxlength' => true]) */ ?>
        </div>
        -->

        <div class="col-sm-6">
            <label for="entradasmedicamentos-idmedi">Medicamento</label>
            <select required class="form-control" name="nombre_medicamento_distribucion" id="entradasmedicamentos-idmedi">
                <?php foreach ($medicamentos as $medicamentos): ?>
                    <option value="<?= $medicamentos['id_detalle_medi'] ?>"><?= $medicamentos['nombre'] ?> <?= $medicamentos['descripcion'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, "idsede")->dropDownList(
                             ArrayHelper::map($sedes, 'idsede', 'nombre'),
                             ['prompt' => 'Seleccione']);?>  
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'cantidad')->textInput(['maxlength' => true, 'type' => 'number']) ?>
        </div>

        <div class="col-sm-6">
            <label for="">Confirma la cantidad de unidades a distribuir</label>
            <input class="form-control" id="confirm-cantidad" type="text" >
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


