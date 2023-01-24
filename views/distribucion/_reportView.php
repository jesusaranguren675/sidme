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
<h4 style="text-align: right; border:none;">LISTADO DE DISTRIBUCIONES DE MEDICAMENTOS</h4>

<br>
<b style="font-size: 9pt; color: #333;">Fecha de Reporte: <?php echo date("d/m/Y") ?></b><br>
<b style="font-size: 9pt; color: #333;">Hora de Reporte: <?php echo date("h:i a") ?></b><br><br>


<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>N°</th>
                                <th>Entrega</th>
                                <th>Destino</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($distribuciones as $distribuciones): ?>
                                <tr>
                                    <td><?= $distribuciones['iddis'] ?></td>
                                    <td><?= $distribuciones['correlativo'] ?></td>
                                    </td>
                                    <td><?= $distribuciones['destino'] ?></td>
                                    <td width="200"><?= $distribuciones['descripcion'] ?></td>
                                    <?php 
                                    $dateString = $distribuciones['fecha'];
                                    $newDateString = date_format(date_create_from_format('Y-m-d', $dateString), 'd-m-Y');
                                    ?>
                                    <td><?= $newDateString ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
