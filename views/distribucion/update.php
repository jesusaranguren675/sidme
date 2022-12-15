<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Distribucion */

$this->title = 'Update Distribucion: ' . $model->iddis;
$this->params['breadcrumbs'][] = ['label' => 'Distribucions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->iddis, 'url' => ['view', 'iddis' => $model->iddis]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="distribucion-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
