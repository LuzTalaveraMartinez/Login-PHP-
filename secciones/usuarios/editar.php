<?php

include('../../conexion.php');



include('../../templates/header.php');





//SELECCIONAR REGISTRO PARA RECUPERAR (datos recolectados por GET)




if (isset($_GET['txtID'])) {


    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";


    $sentencia = $conexion->prepare("SELECT * FROM usuarios WHERE id=:id");


    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $registro = $sentencia->fetch(PDO::FETCH_LAZY); //Para traer solo un registro
    $usuario = $registro["usuario"];
    $password = $registro["password"];
    $correo = $registro["correo"];
}




// EDITAR (datos que vienen por POST)





if ($_POST) {
    //print_r($_POST);

    //Validamos los dstos que viene por POST

    $txtID = (isset($_POST['txtID'])) ? $_POST['txtID'] : "";
    $usuario = (isset($_POST['usuario']) ? $_POST['usuario'] : "");
    $password = (isset($_POST['password']) ? $_POST['password'] : "");
    $correo = (isset($_POST['correo']) ? $_POST['correo'] : "");

    // La insercción de los datos
    $sentencia = $conexion->prepare("UPDATE usuarios  SET usuario=:usuario, password=:password, correo=:correo WHERE id=:id");

    // Asignamos los valores que vienen del método POST (los del formulario)

    $sentencia->bindParam(':usuario', $usuario);
    $sentencia->bindParam(':id', $txtID);
    $sentencia->bindParam(':password', $password);
    $sentencia->bindParam(':correo', $correo);
    $sentencia->execute();
    $mensaje = "Registro actualizado";
    header("Location:index.php?mensaje=" . $mensaje);
}



include('../../templates/header.php');
?>

<br>

<br>

<div class="card">
    <div class="card-header">
        Dato del usuario
    </div>
    <div class="card-body">

        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input type="text" value="<?php echo $txtID; ?>" readonly class="form-control" name="txtID" id="txtID" aria-describedby="helpId">
            </div>
            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre del usuario: </label>
                <input type="text" value="<?php echo $usuario; ?>" class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Escriba el nombre del usuario">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña: </label>
                <input type="text" value="<?php echo $password; ?>" class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Actualizar su contraseña">
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo: </label>
                <input type="email" value="<?php echo $correo; ?>" class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="Escriba su correo">
            </div>
            <button type="submit" class="btn btn-success">Actualizar</button>
            <a name="eliminar" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
        </form>

    </div>
    <div class="card-footer text-muted">

    </div>
</div>
<br><br>

<?php
include('../../templates/footer.php');
?>