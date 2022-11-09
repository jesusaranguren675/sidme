<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Sede $model */

$this->title = 'Update Sede: ' . $model->idsede;
$this->params['breadcrumbs'][] = ['label' => 'Sedes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idsede, 'url' => ['view', 'idsede' => $model->idsede]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sede-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
