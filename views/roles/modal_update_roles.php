<?php

use Yii\helpers\Html;
use Yii\helpers\Url;
?>

<!-- Modal Actualizar Recepciones de Medicamentos -->
<div class="modal fade" id="actualizarRoles" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="actualizarRolesLabel" aria-hidden="true">
  <div style="position:relative; width:40%;" class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="actualizarRolesLabel">Modificar Rol</h5>
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
      <a type="button" class="btn btn-secondary" href="<?= Url::toRoute('roles/index'); ?>">Cerrar</a>
        <button id="modificar_rol" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal Actualizar Recepciones de Medicamentos -->