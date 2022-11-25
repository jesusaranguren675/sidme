<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$roles = \app\models\Roles::find()->all();

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */
/** @var yii\widgets\ActiveForm $form */
?>

<?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'enableAjaxValidation' => false,
    ]); ?>

<div class="row">
    <div class="col-sm-6">
        <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true, 'type' => 'password']) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-sm-6">
        <label for="usuario-status">Estatus</label>
        <select class="form-control" name="usuario-status" id="usuario-status">
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
        </select>
    </div>
    <div class="col-sm-12">
            <?= $form->field($model, "rol")->dropDownList(
                                ArrayHelper::map($roles, 'id_rol', 'nombre_rol'),
                                ['prompt' => 'Seleccionar']);?>
    </div>
</div>

<?php ActiveForm::end(); ?>



