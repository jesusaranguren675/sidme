<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Tipomedicamento */
/* @var $form yii\widgets\ActiveForm */
?>


<?php $form = ActiveForm::begin([
            'enableClientValidation' => false,
            'enableAjaxValidation' => false,]); ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

<?php ActiveForm::end(); ?>
