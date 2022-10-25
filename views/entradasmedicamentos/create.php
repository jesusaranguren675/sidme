<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Entradasmedicamentos */

$this->title = 'Agregar Medicamento';
$this->params['breadcrumbs'][] = ['label' => 'Entradasmedicamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="entradasmedicamentos-create">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
