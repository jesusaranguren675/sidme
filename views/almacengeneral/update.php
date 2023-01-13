<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Almacengeneral */

$this->title = 'Update Almacengeneral: ' . $model->idal_gral;
$this->params['breadcrumbs'][] = ['label' => 'Almacengenerals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idal_gral, 'url' => ['view', 'idal_gral' => $model->idal_gral]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="almacengeneral-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
