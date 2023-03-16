<?php

include('../../conexion.php');


$sentencia = $conexion->prepare("SELECT * FROM usuarios");
$sentencia->execute();
$lista_de_usuarios = $sentencia->fetchAll(PDO::FETCH_ASSOC);
//print_r($lista_de_puestos);

// EIMINAR REGISTRO

if(isset($_GET['txtID'])){


    $txtID=(isset($_GET['txtID'])) ? $_GET['txtID']:"";


    $sentencia=$conexion->prepare("DELETE FROM usuarios  WHERE id=:id");

    

    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    //Se redirecciona al Iindex

    $mensaje="Registro eliminado";

    header("Location:index.php?mensaje=".$mensaje);
}







include('../../templates/header.php');
?>


<br>
<br>
<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar usuario</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Usuario</th>
                        <th scope="col">Contraseña</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_de_usuarios as $registro) { ?>
                        <tr class="">
                            <td scope="row"><?php echo $registro['id'] ?></td>
                            <td><?php echo $registro['usuario'] ?></td>
                            <td>*****</td>
                            <td><?php echo $registro['correo'] ?></td>
                            <td>
                                <a name="btneditar" id="btneditar" class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id']; ?>" role="button">Editar</a>
                                <a name="btnborrar" id="btneliminar" class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']; ?>);" role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer text-muted"></div>
</div>
<br>
<br>

<br>
<br>
<?php
include('../../templates/footer.php');
?>