<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Medicamentos */
/* @var $form yii\widgets\ActiveForm */

$presentaciones = 
Yii::$app->db->createCommand("SELECT idtipo, descripcion
FROM public.tipo_medicamento;")->queryAll();
?>


    <?php $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'enableAjaxValidation' => false,]); 
    ?>

    <div class="row">
        <div class="col-sm-6">
            <label for="nombre-update">Medicamento</label>
            <input id="nombre-update" class="form-control" maxlength="20" type="text">
        </div>

        <input id="id_detalle_medi-update" type="hidden" value="">

        <input id="idmedi-update" type="hidden" value="">

        <div class="col-sm-6">
            <label for="presentacion">Presentación</label>
            <select class="form-control" name="presentacion" id="presentacion-update">
                <option>Seleccione</option>
                <?php foreach ($presentaciones as $presentaciones): ?>
                    <option value="<?= $presentaciones['idtipo'] ?>"><?= $presentaciones['descripcion'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
