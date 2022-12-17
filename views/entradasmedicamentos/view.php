<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Entradasmedicamentos */

$this->title = $model->identrada;
$this->params['breadcrumbs'][] = ['label' => 'Entradasmedicamentos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="entradasmedicamentos-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'identrada' => $model->identrada], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'identrada' => $model->identrada], [
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
            'identrada',
            'descripcion',
            'idusu',
        ],
    ]) ?>

</div>
