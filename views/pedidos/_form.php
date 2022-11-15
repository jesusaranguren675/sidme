<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
$sedes = \app\models\Sede::find()->all();

/* @var $this yii\web\View */
/* @var $model app\models\Pedidos */
/* @var $form yii\widgets\ActiveForm */

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
?>

<div class="pedidos-form" id="pedidos">
    Registrar pedido
    <hr>
    <?php $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'enableAjaxValidation' => false,]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true, 'id' => 'pedido-descripcion']) ?>
        </div>

        <div class="col-sm-6">
            <label for="entradasmedicamentos-idmedi">Medicamento</label>
            <select class="form-control" name="nombre_medicamento_pedido" id="pedido-idmedi">
                <?php foreach ($medicamentos as $medicamentos): ?>
                    <option value="<?= $medicamentos['id_detalle_medi'] ?>"><?= $medicamentos['nombre'] ?> <?= $medicamentos['descripcion'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>


        <div class="col-sm-6">
            <?= $form->field($model, "idsede")->dropDownList(
                                ArrayHelper::map($sedes, 'idsede', 'nombre'),
                                ['id' => 'pedido-sede']);?>  
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'cantidad')->textInput(['maxlength' => true, 'type' => 'number', 'id' => 'pedido-cantidad']) ?>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>
