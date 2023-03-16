<?php
include('../../conexion.php');


// ELIMINAR REGISTRO

if (isset($_GET['txtID'])) {


    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";


    $sentencia = $conexion->prepare("DELETE FROM puestos   WHERE id=:id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
    $mensaje="Registro eliminado";

    header("Location:index.php?mensaje=".$mensaje);
}

$sentencia = $conexion->prepare("SELECT * FROM puestos");
$sentencia->execute();
$lista_de_puestos = $sentencia->fetchAll(PDO::FETCH_ASSOC);
//print_r($lista_de_puestos);


include('../../templates/header.php');
?>
<br>
<br>

<div class="card">
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar puesto</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Nombre del puesto</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_de_puestos as $registro) { ?>
                        <tr class="">
                            <td scope="row"><?php echo $registro['id'] ?></td>
                            <td><?php echo $registro['nombredelpuesto'] ?></td>
                            <td>

                                <a name="btnborrar" id="btneliminar" class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id']; ?>" role="button">Editar</a>
                                <a name="btnborrar" id="btneliminar" class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']; ?>);" role="button">Eliminar</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
include('../../templates/footer.php');
?>