<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Medialmaxpre */

$this->title = $model->id_medi_alma_x_pre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Medialmaxpres'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="medialmaxpre-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id_medi_alma_x_pre' => $model->id_medi_alma_x_pre], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id_medi_alma_x_pre' => $model->id_medi_alma_x_pre], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_medi_alma_x_pre',
            'id_medicamento_almacen',
            'id_presentacion',
            'stock',
        ],
    ]) ?>

</div>
