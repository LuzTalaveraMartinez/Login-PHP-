<?php

include('../../conexion.php');

if (isset($_GET['txtID'])) {


    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";


    $sentencia = $conexion->prepare("SELECT *, (SELECT nombredelpuesto FROM puestos WHERE puestos.id=empleados.idpuesto limit 1) as puesto FROM empleados WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $registro = $sentencia->fetch(PDO::FETCH_LAZY); //Para traer solo un registro

    print_r($registro);


    $primernombre = $registro["primernombre"];
    $segundonombre= $registro["segundonombre"];
    $primerapellido = $registro["primerapellido"];
    $segundoapellido = $registro["segundoapellido"];

    $nombreCompleto=$primernombre ." " .$segundonombre." " .$primerapellido." " .$segundoapellido;
    $foto = $registro["foto"];
    $cv = $registro["cv"];
    $idpuesto = $registro["idpuesto"];
    $puesto=$registro['puesto'];
    $fechadeingreso = $registro["fechadeingreso"];


    $fechaInicio= new DateTime($fechadeingreso);
    $fechaFin=new DateTime(date('Y-m-d'));
    $diferencia=date_diff($fechaInicio, $fechaFin);
}

ob_start(); // ESTO ES TODO LO QUE SE VA A RECOLECTAR Y SE VA A IMPRIMIR (se almacena en $HTML)
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Carta de Recomendación</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
</head>
<body>
<h1>Carta de Recomendación Laboral</h1>

Merida Bs.As, Argentina <strong/> <?php echo date("d M Y"); ?></strong> 
<br><br>
A quien pueda interesar: 
<br><br>
Reciba un cordial y respetuoso saludo.
<br><br>
A través de estas líneas deseo hacer de su conocimienyo que Sr(a) <strong><?php echo $nombreCompleto ?></strong>,
quien colaboró en mi organización durante <strong><?php echo $diferencia->y; ?> año(s)</strong>.
<br>
Ha demostrado con una conducta intachable, comprometido, responsable y fiel cumplidor, capacitarse y actualizar sus conncimientos.<br>
Durante estos años se ha desempeñado como : <strong><?php echo $puesto; ?></strong>
Es por ella le sugiero considere esta recomendación, con la confianza de que estará siempre a la altura de sus compromisos y responsabilidades.
Sin más nada a que referirme y, esperando que esta misiva sea tomada en cuenta, dejo mi número de contacto para cualquier información de interés.
<br><br><br><br><br>
____________________________________________<br>
Atentamente, 
<br>
Ing. Leonardo Nicola.
</body>
</html>

<?php

$html=ob_get_clean();

require_once("../../libs/autoload.inc.php");

use Dompdf\Dompdf;

$dompdf= new Dompdf();

$opciones= $dompdf->getOptions();
$opciones->set(array("isRemoteEnabled" => true));

$dompdf->setOptions($opciones);

$dompdf->loadHtml($html);

$dompdf->setPaper('letter');
// $dompdf->setPaper('A4', 'landscape');
$dompdf->render();
$dompdf->stream("archivo.pdf", array("Attachment" => false));
?>