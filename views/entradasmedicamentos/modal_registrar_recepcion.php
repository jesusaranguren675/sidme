<?php

use Yii\helpers\Html;
use Yii\helpers\Url;
?>

<!-- Modal Agregar Medicamentos -->
<div class="modal fade" id="agregarMedicamentos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="agregarMedicamentosLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="agregarMedicamentosLabel">Agregar Medicamentos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= $this->render('create', [
        'model' => $model,
        ]) ?>
      </div>
      <div class="modal-footer">
        <a type="button" class="btn btn-secondary" href="<?= Url::toRoute('entradasmedicamentos/index'); ?>">Cerrar</a>
        <button id="registrar_medicamento" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal Agregar Medicamentos -->