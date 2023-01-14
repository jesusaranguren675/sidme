<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

$roles = \app\models\Roles::find()->all();

/** @var yii\web\View $this */
/** @var app\models\Usuario $model */
/** @var yii\widgets\ActiveForm $form */


$roles = 
Yii::$app->db->createCommand("SELECT * from roles")->queryAll();

?>

<?php $form = ActiveForm::begin([
        'enableClientValidation' => false,
        'enableAjaxValidation' => false,
    ]); ?>

<div class="row">
    <input type="hidden" id="id-usuario">
    <div class="col-sm-6">
        <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'id' => 'username-update']) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true, 'type' => 'password', 'id' => 'password_hash-update']) ?>
    </div>
    <div class="col-sm-6">
        <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'id' => 'email-update']) ?>
    </div>
    <div class="col-sm-6">
        <label for="usuario-status">Estatus</label>
        <select class="form-control" name="etatus-update" id="etatus-update">
            <option value="1">Activo</option>
            <option value="0">Inactivo</option>
        </select>
    </div>
    <div class="col-sm-12">
            <label for="rol-update">Rol</label>
            <select class="form-control" name="rol-update" id="rol-update">
                <option>Seleccionar</option>
                <?php foreach ($roles as $roles): ?>
                    <option value="<?= $roles['id_rol'] ?>"><?= $roles['nombre_rol'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
</div>

<?php ActiveForm::end(); ?>



