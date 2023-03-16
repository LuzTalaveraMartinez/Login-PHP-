<?php
include('../../conexion.php');


//SELECCIONAR REGISTRO PARA RECUPERAR (datos recolectados por GET)


if (isset($_GET['txtID'])) {


    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";


    $sentencia = $conexion->prepare("SELECT * FROM empleados WHERE id=:id");


    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_LAZY); //Para traer solo un registro

    $primernombre = $registro["primernombre"];
    $segundonombre = $registro["segundonombre"];
    $primerapellido = $registro["primerapellido"];
    $segundoapellido = $registro["segundoapellido"];

    $foto = $registro["foto"];
    $cv = $registro["cv"];

    $idpuesto = $registro["idpuesto"];
    $fechadeingreso = $registro["fechadeingreso"];

    $sentencia = $conexion->prepare("SELECT * FROM puestos");
    $sentencia->execute();
    $lista_de_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

// ACTUALIZAR (Editar) REGISTROS

if ($_POST) {
    //print_r($_POST);
    //print_r($_FILES);

    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $primernombre = (isset($_POST['primernombre']) ? $_POST['primernombre'] : "");
    $segundonombre = (isset($_POST['segundonombre']) ? $_POST['segundonombre'] : "");
    $primerapellido = (isset($_POST['primerapellido']) ? $_POST['primerapellido'] : "");
    $segundoapellido = (isset($_POST['segundoapellido']) ? $_POST['segundoapellido'] : "");
    $idpuesto = (isset($_POST['idpuesto']) ? $_POST['idpuesto'] : "");
    $fechadeingreso = (isset($_POST['fechadeingreso']) ? $_POST['fechadeingreso'] : "");

    // La insercción de los datos
    $sentencia = $conexion->prepare("UPDATE empleados SET 
            primernombre=:primernombre,
            segundonombre=:segundonombre,
            primerapellido=:primerapellido,
            segundoapellido=:segundoapellido,
            idpuesto=:idpuesto,
            fechadeingreso=:fechadeingreso
        WHERE id=:id");

    $sentencia->bindParam(':primernombre', $primernombre);
    $sentencia->bindParam(':segundonombre', $segundonombre);
    $sentencia->bindParam(':primerapellido', $primerapellido);
    $sentencia->bindParam(':segundoapellido', $segundoapellido);
    $sentencia->bindParam(':idpuesto', $idpuesto);
    $sentencia->bindParam(':fechadeingreso', $fechadeingreso);
    $sentencia->bindParam(':id', $txtID);
    $sentencia->execute();

    $foto = (isset($_FILES['foto']['name']) ? $_FILES['foto']['name'] : "");

    $fecha_ = new DateTime();

    $nombreArchivo_foto = ($foto != '') ? $fecha_->getTimestamp() . "_" . $_FILES["foto"]["name"] : "";
    $tmp_foto = $_FILES["foto"]["tmp_name"];





    //CONSULTAMOS SI NOS ENVIAN UNA FOTO




    if ($tmp_foto != "") {
        move_uploaded_file($tmp_foto, "./" . $nombreArchivo_foto); // LA MOVEMOS

        // SELECCIONAMOS LA FOTO 

        $sentencia = $conexion->prepare("SELECT foto FROM empleados WHERE id=:id"); // BUSCAMOS LA FOTO VIEJA
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);



        if (isset($registro_recuperado["foto"]) && $registro_recuperado["foto"] != "") {
            if (file_exists($registro_recuperado["foto"])) {
                unlink("./" . $registro_recuperado['foto']); // SI LA ENCONTRAMOS BORRAMOS LA VIEJA
            }
        }


        // REMPLAZAMOS LA FOTO CON LA NUEVA 

        $sentencia = $conexion->prepare("UPDATE empleados SET foto=:foto WHERE id=:id");
        $sentencia->bindParam(':foto', $nombreArchivo_foto);
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
    }

    // REMPLAZO DE ARCHIVO (en este caso el cv)

    $cv = (isset($_FILES['cv']['name']) ? $_FILES['cv']['name'] : "");

    $nombreArchivo_cv = ($cv != '') ? $fecha_->getTimestamp() . "_" . $_FILES["cv"]["name"] : "";
    $tmp_cv = $_FILES["cv"]["tmp_name"];



    //CONSULTAMOS SI NOS ENVIAN UN ARCHIVO  (En este caso pdf)


    if ($tmp_cv != "") {

        move_uploaded_file($tmp_cv, "./" . $nombreArchivo_cv);
        $sentencia = $conexion->prepare("SELECT cv FROM empleados WHERE id=:id");
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);


        if (isset($registro_recuperado["cv"]) && $registro_recuperado["cv"] != "") {
            if (file_exists($registro_recuperado["cv"])) {
                unlink("./" . $registro_recuperado['cv']); // SI LA ENCONTRAMOS BORRAMOS LA VIEJA
            }
        }


        $sentencia = $conexion->prepare("UPDATE empleados SET cv=:cv WHERE id=:id");
        $sentencia->bindParam(':cv', $nombreArchivo_cv);
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
    }

    $mensaje = "Registro actualizado";
    header("Location:index.php?mensaje=" . $mensaje);
}





include('../../templates/header.php');
?>

<br>

<div class="card">
    <div class="card-header">
        Datos del empleados
    </div>
    <div class="card-body">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input type="text" value="<?php echo $txtID; ?>" readonly class="form-control" name="txtID" id="txtID" aria-describedby="helpId">
            </div>
            <div class="mb-3">
                <label for="primernombre" class="form-label">Primer Nombre:</label>
                <input value="<?php echo $primernombre; ?>" type="text" class="form-control" name="primernombre" id="primernombre" aria-describedby="helpId" placeholder="Escriba su primer nombre">
            </div>
            <div class="mb-3">
                <label for="segundonombre" class="form-label">Segundo Nombre:</label>
                <input value="<?php echo $segundonombre; ?>" type="text" class="form-control" name="segundonombre" id="segundonombre" aria-describedby="helpId" placeholder="Escriba su segundo nombre">
            </div>
            <div class="mb-3">
                <label for="primerapellido" class="form-label">Primer Apellido:</label>
                <input value="<?php echo $primerapellido; ?>" type="text" class="form-control" name="primerapellido" id="primerapellido" aria-describedby="helpId" placeholder="Escriba su primer apellido">
            </div>
            <div class="mb-3">
                <label for="segundoapellido" class="form-label">Segundo Apellido:</label>
                <input value="<?php echo $segundoapellido; ?>" type="text" class="form-control" name="segundoapellido" id="segundoapellido" aria-describedby="helpId" placeholder="Escriba su segundo apellido">
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto: </label>
                <br>
                <img width="100" src="<?php echo $foto; ?>" class=" rounded" alt=""><br /><br />
                <input type="file" class="form-control" name="foto" id="foto" aria-describedby="helpId" placeholder="Foto">

            </div>

            <div class="mb-3">
                <label for="cv" class="form-label">CV (PDF): </label> <br>
                <a href="<?php echo $cv; ?>"> <?php echo $cv; ?></a><br /><br />
                <input value="<?php echo $cv; ?>" type="file" class="form-control" name="cv" id="cv" aria-describedby="helpId" placeholder="CV">

            </div>
            <div class="mb-3">
                <label for="idpuesto" class="form-label">Puesto:</label>

                <select class="form-select form-select-sm" name="idpuesto" id="idpuesto">

                    <?php foreach ($lista_de_puestos as $registro) { ?>
                        <option <?php echo ($idpuesto == $registro['id']) ? "selected" : ""; ?> value="<?php echo $registro['id'] ?>">
                            <?php echo $registro['nombredelpuesto'] ?>
                        </option>
                    <?php } ?>
                </select>

            </div>

            <div class="mb-3">
                <label for="fechadeingreso" class="form-label">Fecha de ingreso: </label>
                <input value="<?php echo $fechadeingreso; ?>" type="date" class="form-control" name="fechadeingreso" id="fechadeingreso" aria-describedby="emailHelpId" placeholder="Feha de ingreso">
            </div>
            <button type="submit" class="btn btn-success">Actualizar registro</button>
            <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
        </form>

    </div>

    <div class="card-footer text-muted"></div>

</div>

<?php
include('../../templates/footer.php');
?>