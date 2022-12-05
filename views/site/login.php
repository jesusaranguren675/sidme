<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap4\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap4\ActiveForm;
use yii\bootstrap4\Html;
use yii\helpers\Url;

$this->title = 'sidmed';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="container-fluid contenedor-form-login">
        <div class="container">
            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 col-md-9">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <img src="<?=  Url::to('@web/img/logo.png') ?>" alt="DSDC" width="100" height="50">
                                            <hr>
                                            <h1 style="margin-bottom: 5px !important; margin-top:5px;" class="h4 text-gray-900 mb-4">Iniciar Sesión</h1>
                                            <hr>
                                            <p>Sistema de Distribución de Medicamentos Del Eje Centro Oeste Del Área de Salud Integral Comunitaria (ASIC).</p>
                                        </div>
                                        <?php $form = ActiveForm::begin([
                                            'id' => 'login-form',
                                            //'layout' => 'horizontal',
                                            //'fieldConfig' => [
                                                //'template' => "{label}\n{input}\n{error}",
                                                //'labelOptions' => ['class' => 'col-lg-1 col-form-label mr-lg-3'],
                                                //'inputOptions' => ['class' => 'col-lg-3 form-control'],
                                                //'errorOptions' => ['class' => 'col-lg-7 invalid-feedback'],
                                            //],
                                        ]); ?>

                                            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                                            <?= $form->field($model, 'password')->passwordInput() ?>

                                            
                                            <?php /* $form->field($model, 'rememberMe')->checkbox([
                                                'template' => "<div class=\"offset-lg-1 col-lg-3 custom-control custom-checkbox\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
                                            ]) */?>

                                            <div class="form-group" style="text-align: center;">
                                                <div class="col-lg-12">
                                                    <?= Html::submitButton('ingresar', ['class' => 'btn btn-primary', 'name' => 'login-button', 'style' => 'width:60%;']) ?>
                                                </div>
                                            </div>

                                        <?php ActiveForm::end(); ?>
                                        <hr>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
