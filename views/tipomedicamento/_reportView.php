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
<div style="width: 100%; margin-bottom:20px;">
    <?= Html::img('@web/img/cintillo_pdf.jpg', ['style' => "width:100%;"]) ?>
</div><br>
<h4 style="text-align:right; border:none;">LISTADO DE PRESENTACIONES</h4>

<br>
<b style="font-size: 9pt; color: #333;">Fecha de Reporte: <?php echo date("d/m/Y") ?></b><br>
<b style="font-size: 9pt; color: #333;">Hora de Reporte: <?php echo date("h:i a") ?></b><br><br>


<table id="table_reportes" class="table table-bordered table-hover table-striped table_reportes">
	<tr>
		<th>N°</th>
		<th>Descripción</th>
	</tr>
	<?php
    $contador = 1;
	foreach ($presentaciones as $presentaciones)
	{
		
		?>
        <tr>
            <td><?= $contador ?></td>
            <td><?= $presentaciones['descripcion'] ?></td>
        </tr>
		<?php
		$contador = $contador + 1;
	}

	?>
</table>
