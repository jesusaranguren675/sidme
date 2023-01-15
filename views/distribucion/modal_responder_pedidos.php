<?php

use Yii\helpers\Html;
use Yii\helpers\Url;
?>
<!-- Modal Responder Pedidos de Medicamentos -->
<div class="modal fade" id="reponderPedidos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="reponderPedidosLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reponderPedidosLabel">Responder Pedidos</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= $this->render('_form_responder_pedidos', [
        'model' => $model,
        ]) ?>
      </div>
      <div class="modal-footer"><!-- data-dismiss="modal" -->
        <button id="back" type="button" class="btn btn-secondary" data-dismiss="modal" >Cerrar</button>
        <button id="responder_pedido" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal Responder Pedidos de Medicamentos -->