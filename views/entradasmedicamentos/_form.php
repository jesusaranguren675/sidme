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
Yii::$app->db->createCommand("SELECT * FROM sede")->queryAll();
/* @var $this yii\web\View */
/* @var $model app\models\Entradasmedicamentos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entradasmedicamentos-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        
        <div class="col-sm-6">
            <label for="entradasmedicamentos-idmedi">Medicamento</label>
            <select id="entradasmedicamentos-idmedi" style="width: 100%" class="js-example-basic-single" name="state">
                <?php foreach ($medicamentos as $medicamentos): ?>
                    <option value="<?= $medicamentos['id_detalle_medi'] ?>"><?= $medicamentos['nombre'] ?> <?= $medicamentos['descripcion'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-sm-6">
            <label for="entradasmedicamentos-cantidad">Cantidad</label>
            <input class="form-control" type="text" id="entradasmedicamentos-cantidad" maxlength="4">
        </div>
  
        <div class="col-sm-6">
            <label for="entradasmedicamentos-idsede">Organización</label>
            <select id="entradasmedicamentos-idsede" style="width: 100%" class="js-example-basic-single" name="state">
                    <option>Seleccione</option>
                <?php foreach ($sedes as $sedes): ?>
                    <option value="<?= $sedes['idsede'] ?>"><?= $sedes['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-sm-6">
            <label for="entradasmedicamentos-descripcion">Descripción</label>
            <input class="form-control" type="text" id="entradasmedicamentos-descripcion" maxlength="35">
        </div>
    </div>


    <?php ActiveForm::end(); ?>

</div>

