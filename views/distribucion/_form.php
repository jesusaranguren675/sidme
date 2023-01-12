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
    <?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'enableAjaxValidation' => false,
    ]); ?>

    <div class="row">
        
        <div class="col-sm-6">
            <label for="distribucion-descripcion">Descripción</label>
            <input class="form-control" type="text" id="distribucion-descripcion" maxlength="35">
        </div>
        
        <div class="col-sm-6">
            <label for="entradasmedicamentos-idmedi">Medicamento</label>
            <select required class="form-control" name="nombre_medicamento_distribucion" id="distribucion-idmedi">
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
        <label for="distribucion-cantidad">Unidades</label>
            <div class="input-group">
                <input maxlength="3" id="distribucion-cantidad" type="text" type="number" class="form-control">
                <div class="input-group-append">
                    <span id="cantidad_de_unidades" class="input-group-text">Disponible 0.00</span>
                </div>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


