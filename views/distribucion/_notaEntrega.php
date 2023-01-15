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

<h5 style="text-align: center; border:none;">ENTREGADO POR EL EJE CENTRO - DISTRITO SANITARIO N° 3</h5>
<h4 style="text-align: center; border:none;">ORDEN DE ENTREGA</h4>

<br>
<table>
    <tr>
        <th style="text-align: left;">Fecha de la Entrega: <?php echo date("d/m/Y") ?></th>
        <th></th>
    </tr>
    <tr>
        <th style="text-align: left;">Hora de la Entrega: <?php echo date("h:i a") ?></th>
        <th style="text-align: right;">
            N° Entrega:
            <?= $correlativo ?>
        </th>
    </tr>
</table><br>


<table id="table_reportes" class="table table-bordered table-hover table-striped table_reportes">
	<tr>
        <th>N°</th>
        <th>Entrega</th>
        <th>Descripción</th>
        <th>Nombre</th>
        <th>Presentación</th>
        <th>Destino</th>
        <th>Cantidad</th>
        <th>Fecha</th>
	</tr>
	<?php
    $contador = 1;
	foreach ($distribucion as $distribucion)
	{
		
		?>
        <tr>
            <td><?= $contador ?></td>
            <td><?= $distribucion['correlativo'] ?></td>
            <td><?= $distribucion['descripcion'] ?></td>
            <td><?= $distribucion['nombre'] ?></td>
            <td><?= $distribucion['presentacion'] ?></td>
            <td><?= $distribucion['destino'] ?></td>
            <td style="text-align: center;">
                <button class="btn btn-warning btn-sm">
                <?= $distribucion['cantidad'] ?>
                </button>
            </td>
            <td><?= $distribucion['fecha'] ?></td>
        </tr>
		<?php
		$contador = $contador + 1;
	}

	?>
</table>
