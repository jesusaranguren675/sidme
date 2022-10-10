<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Almacengeneral */

$this->title = 'Create Almacengeneral';
$this->params['breadcrumbs'][] = ['label' => 'Almacengenerals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="almacengeneral-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
