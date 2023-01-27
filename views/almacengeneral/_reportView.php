<?php

use yii\helpers\Html;

?>

<style>
	body {
		font-family: arial;
		color: #333;

	}
	table{
		border: solid 1px #000;
		border-collapse:collapse;
		border-spacing:0;
        width: 100%;
	}
	tr {
		border: solid 1px #000;
	}
	td {
		border: solid 1px #000;
		font-size: 11.5px;
        padding: 10px;
	}
	th {
		border: solid 1px #000;
		font-size: 11.5px;
        padding: 5px;
	}



</style>
<div style="width: 100%;">
    <?= Html::img('@web/img/cintillo_pdf.jpg', ['style' => "width:100%;"]) ?>
</div>
<h4 style="text-align: right; border:none;">LISTADO DE MEDICAMENTOS DEL INVENTARIO</h4>

<br>
<b style="font-size: 9pt; color: #333;">Fecha de Reporte: <?php echo date("d/m/Y") ?></b><br>
<b style="font-size: 9pt; color: #333;">Hora de Reporte: <?php echo date("h:i a") ?></b><br><br>


<table id="table_reportes" class="table table-bordered table-hover table-striped table_reportes">
	<tr>
		<th>N°</th>
        <th>Medicamento</th>
		<th>Presentación</th>
		<th>Unidades</th>
	</tr>
	<?php
    $contador = 1;
	foreach ($almacen_general as $almacen_general)
	{
		
		?>
        <tr>
            <td><?= $contador ?></td>
            <td><?= $almacen_general['nombre'] ?></td>
            <td><?= $almacen_general['presentacion'] ?></td>
            <td style="text-align: center;">
                <button class="btn btn-warning btn-sm">
                    <?= $almacen_general['cantidad'] ?>
                </button>
            </td>
        </tr>
		<?php
		$contador = $contador + 1;
	}

	?>
</table>
