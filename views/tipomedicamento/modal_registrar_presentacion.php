<?php

use Yii\helpers\Html;
use Yii\helpers\Url;
?>
<!-- Modal Registrar Presentacion del Medicamentos -->
<div class="modal fade" id="modalPresentacion" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modalPresentacionLabel" aria-hidden="true">
  <div style="position:relative;" class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalPresentacionLabel">Registrar Presentación</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= $this->render('create', [
        'model' => $model,
        ]) ?>
      </div>
      <div class="modal-footer"><!-- data-dismiss="modal" -->
        <button id="back" type="button" class="btn btn-secondary" data-dismiss="modal" >Cerrar</button>
        <button id="registrar_presentacion" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal Registrar Presentacion del Medicamentos -->