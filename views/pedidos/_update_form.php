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

$sedes = 
Yii::$app->db->createCommand("SELECT * FROM sede")->queryAll();
?>


<div class="pedidos-form" id="pedidos">
    <?php $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'enableAjaxValidation' => false,]); ?>

    <input id="idpedi-update" type="hidden" value="">

    <div class="row">

        
        <div class="col-sm-6">
            <?= $form->field($model, 'descripcion')->textInput([
                'maxlength'     => true, 
                'id'            => 'pedido-descripcion-update',
                'value'         => ""]) 
            ?>
        </div>
        
        <!--
        <div class="col-sm-6">
            <label for="pedido-idmedi-update">Medicamento</label>
            <select id="pedido-idmedi-update" style="width: 100%" class="js-example-basic-single" name="state">
                <?php foreach ($medicamentos as $medicamentos): ?>
                    <option value="<?= $medicamentos['id_detalle_medi'] ?>"><?= $medicamentos['nombre'] ?> <?= $medicamentos['descripcion'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        -->

        <div class="col-sm-6">
            <label for="pedido-sede-update">Destino</label>
            <select id="pedido-sede-update" style="width: 100%" class="js-example-basic-single" name="state">
                <option id="destino_name_id_update" value="">Seleccione</option>
                <?php foreach ($sedes as $sedes): ?>
                    <option value="<?= $sedes['idsede'] ?>"><?= $sedes['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <!--
        <div class="col-sm-6">
        <label for="pedido-cantidad">Unidades</label>
            <div class="input-group">
                <input maxlength="3" id="pedido-cantidad-update" type="text" type="number" class="form-control">
                <div class="input-group-append">
                    <span id="cantidad_de_unidades_update" class="input-group-text">Disponible 0.00</span>
                </div>
            </div>
        </div>
        -->


        <div class="col-sm-12">
            <label for="pedido-estatus-update">Estatus</label>
            <select id="pedido-estatus-update" style="width: 100%" class="js-example-basic-single" name="state">
                <option value="">Seleccione</option>
                <option value="1">Aprobado</option>
                <option value="2">Pendiente</option>
                <option value="3">Rechazado</option>
            </select>
        </div>

    </div>

    <?php ActiveForm::end(); ?>

</div>



