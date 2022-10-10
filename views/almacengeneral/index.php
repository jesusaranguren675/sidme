<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\AlmacengeneralSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Almacengenerals';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="almacengeneral-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Almacengeneral', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'idal_gral',
            'idmedi',
            'descripcion',
            'cantidad',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'idal_gral' => $model->idal_gral]);
                 }
            ],
        ],
    ]); ?>


</div>
