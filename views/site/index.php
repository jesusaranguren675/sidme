<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'sidme';
?>


              
<div class="container">
    <h1>Bienvenido al Sistema de Distribucion de Medicamentos</h1>

    <div class="form-group">
        <a class="btn btn-primary" href="<?= Url::toRoute('site/login'); ?>">Iniciar Sesión</a>
    </div>
</div>