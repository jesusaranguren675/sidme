<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\MedialmaxpreSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="medialmaxpre-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id_medi_alma_x_pre') ?>

    <?= $form->field($model, 'id_medicamento_almacen') ?>

    <?= $form->field($model, 'id_presentacion') ?>

    <?= $form->field($model, 'stock') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
