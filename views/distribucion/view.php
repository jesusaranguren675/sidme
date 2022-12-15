<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Distribucion */

$this->title = $model->iddis;
$this->params['breadcrumbs'][] = ['label' => 'Distribucions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="distribucion-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'iddis' => $model->iddis], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'iddis' => $model->iddis], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'iddis',
            'idusu',
            'descripcion',
        ],
    ]) ?>

</div>
