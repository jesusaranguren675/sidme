<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
$tipo_medicamento = \app\models\Tipomedicamento::find()->all();
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
Yii::$app->db->createCommand("SELECT idsede, nombre, ubicacion, telefono, correo
FROM public.sede")->queryAll();
/* @var $this yii\web\View */
/* @var $model app\models\Entradasmedicamentos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entradasmedicamentos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        
        <input id="identrada-update" type="hidden" value="">

        <div class="col-sm-6">
            <label for="entradasmedicamentos-idmedi-update-view">Medicamento</label>
            <input id="entradasmedicamentos-idmedi-update-view" class="form-control" disabled type="text" value="">
            <input id="entradasmedicamentos-idmedi-update" class="form-control" disabled type="hidden" value="">
        </div>


        <div class="col-sm-6">

            <label for="entradasmedicamentos-idsede-update-view">Organización</label>
            <input id="entradasmedicamentos-idsede-update-view" class="form-control" disabled type="text" value="">
            <input id="entradasmedicamentos-idsede-update" class="form-control" disabled type="hidden" value="">
        </div>

        <div class="col-sm-6">
            <label for="entradasmedicamentos-cantidad-update">Cantidad</label>
            <input class="form-control" type="text" id="entradasmedicamentos-cantidad-update" maxlength="3">
        </div>

        <div class="col-sm-6">
            <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true, 'id' => 'entradasmedicamentos-descripcion-update']) ?>
        </div>

    </div>


    <?php ActiveForm::end(); ?>

</div>

