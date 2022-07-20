<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Medialmaxpre */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medialmaxpre-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_medicamento_almacen')->textInput() ?>

    <?= $form->field($model, 'id_presentacion')->textInput() ?>

    <?= $form->field($model, 'stock')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
