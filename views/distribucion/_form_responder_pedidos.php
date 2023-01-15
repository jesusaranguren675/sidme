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

$sedes = 
Yii::$app->db->createCommand("SELECT * FROM sede")->queryAll();

$pedidos = 
Yii::$app->db->createCommand("SELECT pedidos.idpedi, 
pedidos.descripcion,
medicamentos.nombre,
tipo_medicamento.descripcion AS presentacion,
detalle_pedi.cantidad, detalle_pedi.estatus,
detalle_pedi.fecha, detalle_pedi.correlativo as id_orden
FROM pedidos AS pedidos
JOIN detalle_pedi AS detalle_pedi
ON detalle_pedi.idpedi=pedidos.idpedi
JOIN detalle_medi AS detalle_medi
ON detalle_medi.id_detalle_medi=detalle_pedi.idmedi
JOIN medicamentos AS medicamentos
ON medicamentos.idmedi=detalle_medi.idmedi
JOIN tipo_medicamento AS tipo_medicamento
ON tipo_medicamento.idtipo=detalle_medi.idtipo
WHERE detalle_pedi.estatus=1")->queryAll();
/* @var $this yii\web\View */
/* @var $model app\models\Entradasmedicamentos */
/* @var $form yii\widgets\ActiveForm */

/* @var $this yii\web\View */
/* @var $model app\models\Distribucion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="distribucion-form" id="distribucion">
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'enableAjaxValidation' => false,
    ]); ?>

    <div class="row">

        <div class="col-sm-12">
            <label for="responder-pedido">Pedido</label>
            <select id="responder-pedido" style="width: 100%" class="js-example-basic-single" name="state">
                <?php foreach ($pedidos as $pedidos): ?>
                    <option value="<?= $pedidos['idpedi'] ?>"><?= $pedidos['descripcion'] ?>, <?= $pedidos['nombre'] ?> <?= $pedidos['presentacion'] ?> <?= $pedidos['cantidad'] ?> Unidades,  N° Orden <?= $pedidos['id_orden'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="col-sm-6">
            <label for="responder-descripcion">Descripción</label>
            <input class="form-control" type="text" id="responder-descripcion" maxlength="35">
        </div>
        
        <div class="col-sm-6">
            <label for="responder-idmedi">Medicamento</label>
            <select id="responder-idmedi" style="width: 100%" class="js-example-basic-single" name="state">
                <?php foreach ($medicamentos as $medicamentos): ?>
                    <option value="<?= $medicamentos['id_detalle_medi'] ?>"><?= $medicamentos['nombre'] ?> <?= $medicamentos['descripcion'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>



        <div class="col-sm-6">
            <label for="responder-idsede">Destino</label>
            <select id="responder-idsede" style="width: 100%" class="js-example-basic-single" name="state">
                <?php foreach ($sedes as $sedes): ?>
                    <option value="<?= $sedes['idsede'] ?>"><?= $sedes['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="col-sm-6">
        <label for="responder-cantidad">Unidades</label>
            <div class="input-group">
                <input maxlength="3" id="responder-cantidad" type="number" class="form-control">
                <div class="input-group-append">
                    <span id="reponder_cantidad_de_unidades" class="input-group-text">Disponible 0.00</span>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


