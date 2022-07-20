<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Medialmaxpre */

$this->title = Yii::t('app', 'Update Medialmaxpre: {name}', [
    'name' => $model->id_medi_alma_x_pre,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Medialmaxpres'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_medi_alma_x_pre, 'url' => ['view', 'id_medi_alma_x_pre' => $model->id_medi_alma_x_pre]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="medialmaxpre-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
