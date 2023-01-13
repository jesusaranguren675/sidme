<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Sede $model */


$this->params['breadcrumbs'][] = ['label' => 'Sedes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


