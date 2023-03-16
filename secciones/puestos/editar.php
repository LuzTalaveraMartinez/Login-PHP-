<?php

include('../../conexion.php');


    //SELECCIONAR REGISTRO PARA RECUPERAR (datos recolectados por GET)


if(isset($_GET['txtID'])){


    $txtID=(isset($_GET['txtID'])) ? $_GET['txtID']:"";


    $sentencia=$conexion->prepare("SELECT * FROM puestos WHERE id=:id");
   

    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();

    $registro=$sentencia->fetch(PDO::FETCH_LAZY); //Para traer solo un registro
    $nombredelpuesto=$registro["nombredelpuesto"];

}

    // EDITAR (datos que vienen por POST)


    if($_POST){
        //print_r($_POST);
    
        //Validamos los dstos que viene por POST

        $txtID=(isset($_POST['txtID'])) ? $_POST['txtID']:"";
        $nombredelpuesto=(isset($_POST['nombredelpuesto']) ? $_POST['nombredelpuesto']:"");
        
        // La insercción de los datos
        $sentencia=$conexion->prepare("UPDATE puestos  SET nombredelpuesto=:nombredelpuesto WHERE id=:id");
    
        // Asignamos los valores que vienen del método POST (los del formulario)
    
        $sentencia->bindParam(':nombredelpuesto', $nombredelpuesto);
        $sentencia->bindParam(':id', $txtID);
        $sentencia->execute();
        $mensaje="Registro actualizado";
        header("Location:index.php?mensaje=".$mensaje);
        
    }



include('../../templates/header.php');
?>

<br>

<br>

<div class="card">
    <div class="card-header">
        Puestos
    </div>
    <div class="card-body">

        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="txtID" class="form-label">ID:</label>
                <input type="text" value="<?php echo $txtID; ?>" readonly class="form-control" name="txtID" id="txtID" aria-describedby="helpId">
            </div>
            <div class="mb-3">
                <label for="nombredelpuesto" class="form-label">Nombre del puesto: </label>
                <input type="text" value="<?php echo $nombredelpuesto; ?>" class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" placeholder="Escriba el nombre del puesto">
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