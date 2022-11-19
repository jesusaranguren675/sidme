<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tipomedicamento */

$this->title = 'Update Tipomedicamento: ' . $model->idtipo;
$this->params['breadcrumbs'][] = ['label' => 'Tipomedicamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->idtipo, 'url' => ['view', 'idtipo' => $model->idtipo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tipomedicamento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
