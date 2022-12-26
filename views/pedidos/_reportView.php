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

<br><br><br><br><br>
<h3 style="text-align: center; border:none;">LISTADO DE PEDIDOS</h3>
<br>

<table id="table_reportes" class="table table-bordered table-hover table-striped table_reportes">
	<tr>
		<th>N°</th>
		<th>Descripción</th>
		<th>Nombre</th>
		<th>Presentación</th>
		<th>Cantidad</th>
		<th>Estatus</th>
		<th>Fecha</th>
	</tr>
	<?php
	foreach ($pedidos as $pedidos)
	{
		$contador = 1;
		?>
        <tr>
            <td><?= $contador ?></td>
            <!--<td><?php // $pedidos['idpedi'] ?></td>-->
            <td><?= $pedidos['descripcion'] ?></td>
            <td width="100"><?= $pedidos['nombre'] ?></td>
            <td><?= $pedidos['presentacion'] ?></td>
            <td style="text-align: center;">
                <button class="btn btn-warning btn-sm">
                    <?= $pedidos['cantidad'] ?>
                </button>
            </td>
            <td style="text-align: center;">
                <?php
                    if($pedidos['estatus'] === 1)
                    {
                        ?>
                            <button class="btn btn-success btn-sm">Aprobado</button>
                        <?php
                    }
                    if($pedidos['estatus'] === 2)
                    {
                        ?>
                            <button class="btn btn-primary btn-sm">Pendiente</button>
                        <?php
                    }
                    if($pedidos['estatus'] === 3)
                    {
                        ?>
                            <button class="btn btn-danger btn-sm">Rechazado</button>
                        <?php
                    }
                ?>
            </td>
            <td><?= $pedidos['fecha'] ?></td>
        </tr>
		<?php
		$contador ++;
	}

	?>
</table>
