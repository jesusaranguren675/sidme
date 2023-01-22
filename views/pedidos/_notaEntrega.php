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

<h5 style="text-align: center; border:none;">SOLICITADO AL EJE CENTRO - DISTRITO SANITARIO N° 3</h5>
<h4 style="text-align: center; border:none;">ORDEN DEL PEDIDO</h4>

<br>
<table>
    <tr>
        <th style="text-align: left;">Fecha de la orden: <?php echo date("d/m/Y") ?></th>
        <th></th>
    </tr>
    <tr>
        <th style="text-align: left;">Hora de la orden: <?php echo date("h:i a") ?></th>
        <th style="text-align: right;">
            N° Orden:
            <?= $orden ?>
        </th>
    </tr>
</table><br>


<table id="table_reportes" class="table table-bordered table-hover table-striped table_reportes">
	<tr>
        <th>Descripción</th>
        <!--<th>Nombre</th>-->
        <!--<th>Presentación</th>-->
        <th>Destino</th>
        <!--<th>Cantidad</th>-->
        <th>Estatus</th>
        <th>Fecha</th>
	</tr>
	<?php

	foreach ($pedidos as $pedidos)
	{
		?>
        <tr>
            <td><?= $pedidos['descripcion'] ?></td>
            <!--<td width="100"><?= $pedidos['nombre'] ?></td>-->
            <!--<td><?= $pedidos['presentacion'] ?></td>-->
            <td><?= $pedidos['procedencia'] ?></td>
            <!--
            <td style="text-align: center;">
                <button class="btn btn-warning btn-sm">
                <?= $pedidos['cantidad'] ?>
                </button>
            </td>
            -->
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
                    if($pedidos['estatus'] === 4)
                    {
                        ?>
                        <button class="btn btn-danger btn-sm">Culminado</button>
                        <?php
                    }
                    ?>
                    </td>
            <td><?= $pedidos['fecha'] ?></td>
        </tr>
		<?php
	}

	?>
</table>

<br>

<table id="table_reportes" class="table table-bordered table-hover table-striped table_reportes">
	<tr>
        <th>N°</th>
        <th>Nombre</th>
        <th>Presentación</th>
        <th>Cantidad</th>
	</tr>
	<?php
        $contador = 1;
        foreach ($medicamentos as $medicamentos)
        {
            
            ?>
            <tr>
                <td><?= $contador ?></td>
                <td><?= $medicamentos['nombre'] ?></td>
                <td><?= $medicamentos['presentacion'] ?></td>
                
                <td style="text-align: center;">
                    <button class="btn btn-warning btn-sm">
                    <?= $medicamentos['cantidad'] ?>
                    </button>
                </td>
            </tr>
            <?php
            $contador = $contador + 1;
        }
	?>
</table>
