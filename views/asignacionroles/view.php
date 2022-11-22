<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Asignacionroles */

$this->title = $model->id_asig_rol;
$this->params['breadcrumbs'][] = ['label' => 'Asignacionroles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="asignacionroles-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_asig_rol' => $model->id_asig_rol], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_asig_rol' => $model->id_asig_rol], [
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
            'id_asig_rol',
            'id_rol',
            'id_usu',
            'fecha',
        ],
    ]) ?>

</div>
