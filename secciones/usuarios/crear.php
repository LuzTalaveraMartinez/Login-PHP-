<?php

include('../../conexion.php');

if ($_POST) {
    print_r($_POST);

    //Validamos los dstos que viene por POST

    $usuario = (isset($_POST['usuario']) ? $_POST['usuario'] : "");
    $password = (isset($_POST['password']) ? $_POST['password'] : "");
    $correo = (isset($_POST['correo']) ? $_POST['correo'] : "");

    // La insercción de los datos
    $sentencia = $conexion->prepare("INSERT INTO usuarios (id, usuario, password, correo) 
    VALUES (null, :usuario, :password, :correo)");

    // Asignamos los valores que vienen del método POST (los del formulario)

    $sentencia->bindParam(':usuario', $usuario);
    $sentencia->bindParam(':password', $password);
    $sentencia->bindParam(':correo', $correo);
    $sentencia->execute();
    $mensaje = "Registro agregado";
    header("Location:index.php?mensaje=" . $mensaje);
}

include('../../templates/header.php');
?>

<br>

<br>

<div class="card">
    <div class="card-header">
        Datos del usuario
    </div>
    <div class="card-body">

        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre del usuario: </label>
                <input type="text" class="form-control" name="usuario" id="usuario" aria-describedby="helpId" placeholder="Nombre del usuario">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña: </label>
                <input type="password" class="form-control" name="password" id="password" aria-describedby="helpId" placeholder="Escriba su contraseña">
            </div>
            <div class="mb-3">
                <label for="correo" class="form-label">Correo: </label>
                <input type="email" class="form-control" name="correo" id="correo" aria-describedby="helpId" placeholder="Email">
            </div>
            <button type="submit" class="btn btn-success">Agregar</button>
            <a name="eliminar" id="" class="btn btn-danger" href="index.php" role="button">Cancelar</a>
        </form>

    </div>
    <div class="card-footer text-muted">

    </div>
</div>
<br>
<br>
<?php
include('../../templates/footer.php');
?>