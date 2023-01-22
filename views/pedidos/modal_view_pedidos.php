<!-- Modal Ver Registros de Pedidos -->
<div class="modal fade" id="viewPedido" tabindex="-1" aria-labelledby="viewPedidoLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="viewPedidoLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tr>
                    <th>N°</th>
                    <th>Orden</th>
                    <th>Descripción</th>
                    <!--
                    <th>Nombre</th>
                    <th>Presentación</th>
                    <th>Cantidad</th>
                    -->
                    <th>Estatus</th>
                    <th>Fecha</th>
                </tr>
                <tr>
                    <td id="data_1"></td>
                    <td id="data_2"></td>
                    <td id="data_3"></td>
                    <td id="data_4"></td>
                    <td id="data_5"></td>
                </tr>
            </table>
        </div>

        <div id="table_medicamentos" class="table_medicamentos">
          
        </div>
      </div>
      <div class="modal-footer">
        <button id="cerrar_modal_view" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal Ver Registros de Pedidos -->