<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Tipomedicamento */

$this->title = 'Create Tipomedicamento';
$this->params['breadcrumbs'][] = ['label' => 'Tipomedicamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tipomedicamento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
