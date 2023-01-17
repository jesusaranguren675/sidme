<?php

use Yii\helpers\Html;
use Yii\helpers\Url;
?>

<!-- Modal Actualizar Sedes -->
<div class="modal fade" id="actualizarSedes" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="actualizarSedesLabel" aria-hidden="true">
  <div style="position:relative;" class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="actualizarSedesLabel">Modificar Sedes</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= $this->render('_update_form', [
        'model' => $model,
        ]) ?>
      </div>
      <div class="modal-footer"><!-- data-dismiss="modal" -->
        <a id="back" type="button" class="btn btn-secondary" href="<?= Url::toRoute('sede/index'); ?>" >Cerrar</a>
        <button id="modificar_sede" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal Actualizar Sedes -->0.