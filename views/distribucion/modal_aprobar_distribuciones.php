<?php

use yii\helpers\Url;
use yii\helpers\Html;

?>


<!-- MODAL APROBAR DISTRIBUCIÓN -->

<div class="modal fade" id="aprobardistribucion" tabindex="-1" aria-labelledby="aprobardistribucionLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" style="width:30%;">
    <div class="modal-content">
      <div class="modal-header" style="display: flex; justify-content:center;">
        <h5 class="modal-title" id="aprobardistribucionLabel">Responder Distribución</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
            <div class="form-group">
                <input id="idpedi_dis" type="hidden" value="">
                <input id="descripcion_dis" class="form-control" placeholder="Coloca una Descripción..." type="text" >
            </div>
        </form>
      </div>
      <div class="modal-footer" style="display: flex; justify-content:center;">
        <button type="button" 
                class="btn btn-danger" 
                data-dismiss="modal"
                title="Cancelar"
                style="width: 20%;">
            <i class="fas fa-times"></i>
        </button>
        <button type="button"
                id="distribuir_pedido"
                class="btn btn-success"
                title="Aprobar"
                style="width: 20%;">
            <i class="fas fa-check"></i>
        </button>
      </div>
    </div>
  </div>
</div>

<!-- FIN MODAL APROBAR DISTRIBUCIÓN -->