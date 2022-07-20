<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\MedialmaxpreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Medicamentos del Almacen');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="medialmaxpre-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Agregar Medicamento'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_medi_alma_x_pre',
            'id_medicamento_almacen',
            'id_presentacion',
            'stock',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, \app\models\Medialmaxpre $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_medi_alma_x_pre' => $model->id_medi_alma_x_pre]);
                 }
            ],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

    <?php foreach ($almacen as $almacen): ?>
        <p>ID. <?= $almacen['id_medi_alma_x_pre'] ?></p>
        <p>Medicamento: <?= $almacen['nombre_medicamento_almacen'] ?></p>
        <p>Presentacion: <?= $almacen['nombre_presentacion'] ?></p>
        <p>Entrada: <?= $almacen['entrada'] ?></p>
        <p>Salida: <?= $almacen['salida'] ?></p>
        <p>Existencia: <?= $almacen['existencia'] ?></p>
    <?php endforeach; ?>


</div>
