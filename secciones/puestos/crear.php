<?php

include('../../conexion.php');

if($_POST){
    print_r($_POST);

    //Validamos los dstos que viene por POST

    $nombredelpuesto=(isset($_POST['nombredelpuesto']) ? $_POST['nombredelpuesto']:"");
    
    // La insercción de los datos
    $sentencia=$conexion->prepare("INSERT INTO puestos (id, nombredelpuesto) VALUES (null, :nombredelpuesto)");

    // Asignamos los valores que vienen del método POST (los del formulario)

    $sentencia->bindParam(':nombredelpuesto', $nombredelpuesto);
    $sentencia->execute();
    $mensaje="Registro agregado";
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
              <label for="nombredelpuesto" class="form-label">Nombre del puesto: </label>
              <input type="text"
                class="form-control" name="nombredelpuesto" id="nombredelpuesto" aria-describedby="helpId" placeholder="Escriba el nombre del puesto">             
            </div>
            <button type="submit" class="btn btn-success">Agregar</button>
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
