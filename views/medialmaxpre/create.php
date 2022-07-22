<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Medialmaxpre */

$this->title = Yii::t('app', 'Agregar Medicamento Al Almacen');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Medialmaxpres'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medialmaxpre-create">

    <h1></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
