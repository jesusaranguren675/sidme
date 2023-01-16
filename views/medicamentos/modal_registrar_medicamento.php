<?php

use Yii\helpers\Html;
use Yii\helpers\Url;
?>

<!-- Modal Registrar Medicamentos -->
<div class="modal fade" id="medicamento" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="medicamentoLabel" aria-hidden="true">
  <div style="position:relative;" class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="medicamentoLabel">Registrar Medicamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= $this->render('_form', [
        'model' => $model,
        ]) ?>
      </div>
      <div class="modal-footer"><!-- data-dismiss="modal" -->
        <a id="back" type="button" class="btn btn-secondary" href="<?= Url::toRoute('medicamentos/index'); ?>" >Cerrar</a>
        <button id="registrar_medicamento" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal Registrar Medicamentos -->