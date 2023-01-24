<?php

use Yii\helpers\Html;
use Yii\helpers\Url;
?>
<!-- Modal Registrar Distribución de Medicamentos -->
<div class="modal fade" id="distribuirMedicamentos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="distribuirMedicamentosLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="distribuirMedicamentosLabel">Distribuir Medicamentos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <br>
        <?= $this->render('create', [
        'model' => $model,
        ]) ?>
        <br><br><br>
      </div>
      <div class="modal-footer"><!-- data-dismiss="modal" -->
        <a id="back" type="button" class="btn btn-secondary"  href="<?= Url::toRoute('distribucion/index'); ?>" >Cerrar</a>
        <button id="registrar_distribucion" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal Registrar Distribución de Medicamentos -->