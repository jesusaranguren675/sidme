<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Medialmaxpre */

$this->title = Yii::t('app', 'Create Medialmaxpre');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Medialmaxpres'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medialmaxpre-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
