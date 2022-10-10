<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Almacengeneral */

$this->title = $model->idal_gral;
$this->params['breadcrumbs'][] = ['label' => 'Almacengenerals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="almacengeneral-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idal_gral' => $model->idal_gral], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idal_gral' => $model->idal_gral], [
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
            'idal_gral',
            'idmedi',
            'descripcion',
            'cantidad',
        ],
    ]) ?>

</div>
