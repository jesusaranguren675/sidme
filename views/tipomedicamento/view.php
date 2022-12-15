<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Tipomedicamento */

$this->title = $model->idtipo;
$this->params['breadcrumbs'][] = ['label' => 'Tipomedicamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="tipomedicamento-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'idtipo' => $model->idtipo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'idtipo' => $model->idtipo], [
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
            'idtipo',
            'descripcion',
        ],
    ]) ?>

</div>
