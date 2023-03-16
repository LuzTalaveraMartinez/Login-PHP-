<?php
include('../../conexion.php');




$sentencia = $conexion->prepare("SELECT *, (SELECT nombredelpuesto FROM puestos WHERE puestos.id=empleados.idpuesto limit 1) as puesto FROM empleados");
$sentencia->execute();
$lista_de_empleados = $sentencia->fetchAll(PDO::FETCH_ASSOC);
//print_r($lista_de_puestos);



// ELIMINAR EMPLEADO

if (isset($_GET['txtID'])) {


    $txtID = (isset($_GET['txtID'])) ? $_GET['txtID'] : "";


    $sentencia = $conexion->prepare("SELECT foto,cv FROM empleados WHERE id=:id");
    $sentencia->bindParam(':id',$txtID);
    $sentencia->execute();
    $registro_recuperado = $sentencia->fetch(PDO::FETCH_LAZY);


    //Borrado de la foto

    if(isset($registro_recuperado["foto"]) && $registro_recuperado["foto"]!=""){
        if(file_exists($registro_recuperado["foto"])){
            unlink("./" .$registro_recuperado['foto']);
        }
    }

    //Borrado del archivo PDF (cv)

    if(isset($registro_recuperado["cv"]) && $registro_recuperado["cv"]!=""){
        if(file_exists($registro_recuperado['cv'])){
            unlink("./" .$registro_recuperado['cv']);
        }
    }

    // Borrar todo el registro

    $sentencia = $conexion->prepare("DELETE FROM empleados WHERE id=:id");



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
    <br>

    <br>
    <div class="card-header">
        <a name="" id="" class="btn btn-primary" href="crear.php" role="button">Agregar registro</a>
    </div>
    <div class="card-body">
        <div class="table-responsive-sm">
            <table class="table" id="tabla_id">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Foto</th>
                        <th scope="col">CV</th>
                        <th scope="col">Puesto</th>
                        <th scope="col">Fecha de ingreso</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_de_empleados as $registro) { ?>
                        <tr class="">
                            <td scope="row"><?php echo $registro['id'] ?> </td>
                            <td scope="row">
                                <?php echo $registro['primernombre']; ?>
                                <?php echo $registro['segundonombre']; ?>
                                <?php echo $registro['primerapellido']; ?>
                                <?php echo $registro['segundoapellido']; ?>
                            </td>
                            <td>
                                <img width="50" src="<?php echo $registro['foto']; ?>" class="img-fluid rounded" alt="">
                            </td>
                            <td>
                                <a href="<?php echo $registro['cv']; ?>">
                                <?php echo $registro['cv']; ?>
                            </td>
                            <td><?php echo $registro['puesto']; ?></td>
                            <td><?php echo $registro['fechadeingreso']; ?></td>
                            <td>
                               
                               <a name="btneditar" id="btneditar" class="btn btn-info" href="editar.php?txtID=<?php echo $registro['id']; ?>" role="button">Editar</a>
                               <a name="btnborrar" id="btnborrar" class="btn btn-danger" href="javascript:borrar(<?php echo $registro['id']; ?>);" role="button">Eliminar</a>
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