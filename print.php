<?php
include("bd.php");
if (isset($_GET["searchCURP"])) {
	$curp = $_GET["searchCURP"];

	$query = "SELECT tbl_curp.curp, tbl_person.name, tbl_person.surname, tbl_person.second_surname, tbl_person.birthday, tbl_person.gender, tbl_person.state 
              FROM tbl_curp 
              INNER JOIN tbl_person ON tbl_curp.id_person = tbl_person.id
              WHERE tbl_curp.curp = '$curp'";

	$result = $conexion->query($query);
	$row = $result->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Informacion encontrada</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<style type="text/css">
		body {
			background-color: #f2f2f2;
			font-family: Arial, sans-serif;
			font-size: 12pt;
		}

		.container {
			margin: 30px auto;
			max-width: 600px;
			background-color: #fff;
			padding: 20px;
			border: 2px solid #ccc;
			border-radius: 5px;
			box-shadow: 5px 5px 5px #999;
		}

		h1,
		h2 {
			text-align: center;
			color: #006699;
			margin: 0;
		}

		h2 {
			font-size: 16pt;
		}

		.row {
			display: grid;
			grid-template-columns: repeat(2, 1fr);
			grid-gap: 10px;
			margin-bottom: 10px;
		}

		.col {
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 5px;
			box-shadow: 2px 2px 2px #999;
		}

		.col strong {
			font-weight: bold;
		}

		.btn {
			display: block;
			margin: 0 auto;
			padding: 10px 20px;
			background-color: #006699;
			color: #fff;
			border: none;
			border-radius: 5px;
			box-shadow: 2px 2px 2px #999;
			cursor: pointer;
		}

		.btn:hover {
			background-color: #00557e;
		}
	</style>
</head>

<body>
	<div class="container">
		<?php if (isset($row) && isset($_GET["searchCURP"])): ?>
			<h1>Informacion encontrada</h1>
			<h2 style="margin: 5px 0px 10px 0px; color: green;">CURP:
				<?php echo $curp; ?>
			</h2>
			<div class="row">
				<div class="col">
					<p><strong>Nombre:</strong>
						<?= $row["name"] ?>
					</p>
				</div>
				<div class="col">
					<p><strong>Apellido paterno:</strong>
						<?= $row["surname"] ?>
					</p>
				</div>
				<div class="col">
					<p><strong>Apellido materno:</strong>
						<?= $row["second_surname"] ?>
					</p>
				</div>
				<div class="col">
					<p><strong>Fecha de nacimiento:</strong>
						<?= $row["birthday"] ?>
					</p>
				</div>
				<div class="col">
					<p><strong>Genero:</strong>
						<?= $row["gender"] ?>
					</p>
				</div>
				<div class="col">
					<p><strong>Estado:</strong>
						<?= $row["state"] ?>
					</p>
				</div>
			</div>
		<?php endif; ?>
	</div>
</body>

</html>
<?php
$HTML = ob_get_clean();
require_once("libs/autoload.inc.php");
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$opciones = $dompdf->getOptions();
$opciones->set(array("isRemoteEnabled" => true));
$dompdf->setOptions($opciones);
$dompdf->loadHTML($HTML);
$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->stream("archivo.pdf", array("Attachment" => false));
?>