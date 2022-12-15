<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Asignacionroles */

$this->title = 'Update Asignacionroles: ' . $model->id_asig_rol;
$this->params['breadcrumbs'][] = ['label' => 'Asignacionroles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_asig_rol, 'url' => ['view', 'id_asig_rol' => $model->id_asig_rol]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="asignacionroles-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
