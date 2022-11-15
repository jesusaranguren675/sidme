<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EntradasmedicamentosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recepción de Medicamentos';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="container-fluid">
    <h1 class="h3 mb-2 text-gray-800" style="margin-top: 20px;"><?= Html::encode($this->title) ?></h1>
    <hr>

    <a class="btn btn-primary btn-sm"  href="<?= Url::toRoute('entradasmedicamentos/create'); ?> " data-toggle="modal" data-target="#agregarMedicamentos">
        Agregar 
        <i class="fas fa-plus"></i>
    </a>
    <a class="btn btn-danger btn-sm">pdf <i class="far fa-file-pdf"></i></a>
    <a class="btn btn-success btn-sm">excel <i class="far fa-file-excel"></i></a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>N°</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th style="text-align: center;">Acciones</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php foreach ($entradas_medicamentos as $entradas_medicamentos): ?>
                        <tr>
                            <td><?= $entradas_medicamentos['identrada'] ?></td>
                            <td><?= $entradas_medicamentos['nombre'] ?></td>
                            <td width="400"><?= $entradas_medicamentos['descripcion'] ?></td>
                            <td style="text-align: center;">
                                <button class="btn btn-success btn-circle btn-sm">
                                <?= $entradas_medicamentos['cantidad'] ?>
                                </button>
                            </td>
                            <td><?= $entradas_medicamentos['fecha_entrada'] ?></td>
                            <td style="text-align: center;">
                                <a onclick="ver_medica(<?php echo $entradas_medicamentos['identrada']; ?>)" href="" class="btn btn-primary btn-sm">
                                    <i class="far fa-eye"></i>
                                </a>
                                <a  href="<?= Url::to(['entradasmedicamentos/update', 'identrada' => $entradas_medicamentos['identrada']]); ?>" class="btn btn-primary btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal Agregar Medicamentos -->
<div class="modal fade" id="agregarMedicamentos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="agregarMedicamentosLabel" aria-hidden="true">
  <div class="modal-dialog">
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
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="registrar_medicamento" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal Agregar Medicamentos -->

<!-- Modal Modificar Medicamentos -->
<div class="modal fade" id="modificarMedicamentos" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="modificarMedicamentosLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modificarMedicamentosLabel">Modificar Medicamento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= $this->render('update', [
        'model' => $model,
        ]) ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button id="registrar_medicamento" type="button" class="btn btn-primary">Guardar</button>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal Modificar Medicamentos -->

<script>
    function ver_medica(id, event)
    {
        event.preventDefault();
        console.log(id);
    }
</script>