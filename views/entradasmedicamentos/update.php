<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Entradasmedicamentos */

$this->title = 'Update Entradasmedicamentos: ' . $model->identrada;
$this->params['breadcrumbs'][] = ['label' => 'Entradasmedicamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->identrada, 'url' => ['view', 'identrada' => $model->identrada]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="entradasmedicamentos-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
