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
            <div class="col-sm-5">
                <label for="distribucion-idmedi">Medicamento</label>
                <select id="distribucion-idmedi" style="width: 100%" class="js-example-basic-single" name="state">
                    <option>Seleccione</option>
                    <?php foreach ($medicamentos as $medicamentos): ?>
                        <option value="<?= $medicamentos['id_detalle_medi'] ?>"><?= $medicamentos['nombre'] ?> <?= $medicamentos['descripcion'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="col-sm-6">
                <label for="distribucion-cantidad">Unidades</label>
                <div class="input-group">
                    <input maxlength="3" id="distribucion-cantidad" type="text" type="number" class="form-control">
                    <div class="input-group-append">
                        <span id="cantidad_de_unidades" class="input-group-text">Disponible 0.00</span>
                    </div>
                </div>
            </div>

            <div class="col-sm-1" style="display: flex;
            justify-content: center;
            align-items: flex-end;">
                <button id="add_medicine" title="Agregar Medicamento" class="btn btn-primary btn-circle">
                    <i class="fa fa-plus"></i>
                </button>
            </div>
        </div>

    <div class="row">
        <div class="col-sm-6">
            <label for="distribucion-idsede">Destino</label>
            <select id="distribucion-idsede" style="width: 100%" class="js-example-basic-single" name="state">
                <option>Seleccione</option>
                <?php foreach ($sedes as $sedes): ?>
                    <option value="<?= $sedes['idsede'] ?>"><?= $sedes['nombre'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="col-sm-6">
            <label for="distribucion-descripcion">Descripción</label>
            <input class="form-control" type="text" id="distribucion-descripcion" maxlength="35">
        </div>
    </div>

    <?php ActiveForm::end(); ?>
    
    <br>
    <div id="multiples-medicamentos" class="multiples-medicamentos">

    </div>
    <br><br>

</div>


