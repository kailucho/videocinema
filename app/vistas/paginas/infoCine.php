<?php require RUTA_APP.'/vistas/inc/header_admin.php'; ?>
<style>
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  max-width: 300px;
  margin: auto;
  text-align: center;
  font-family: arial;
}

.title {
  color: grey;
  font-size: 18px;
}

#editar{
  border: none;
  outline: 0;
  display: inline-block;
  padding: 8px;
  color: white;
  background-color: #000;
  text-align: center;
  cursor: pointer;
  width: 100%;
  font-size: 18px;
}


a {
  text-decoration: none;
  font-size: 22px;
  color: black;
}

button:hover, a:hover {
  opacity: 0.7;
}
</style>
<div class="container">
  <a  href="<?php echo RUTA_URL;?>paginas/agregarCine/""><button type="submit" class="btn btn-success">Agregar un Local</button></a>
  <div class="row">
    
    <?php foreach($datos['cines'] as $cines) :?>
    <div class="col-25">
      <div class="card">
        <img class="card-img-top" src=" <?php echo RUTA_URL; ?>public/img/<?php echo $_SESSION['id'].$cines->logoCine; ?>" alt="Card image" style="width:100%">
        <a href="<?php echo RUTA_URL;?>paginas/mostrarPeliculas/<?php echo $cines->idcines ?> ">
          <h1><?php echo $cines->nombreCine;?></h1></a>
        <p class="title">Direccion: <?php echo $cines->direccionCine; ?></p>
        <h4 class="card-text"><?php echo $cines->descripcionCine; ?></h4>
        <h4>Horario: <?php echo $cines->horarioCine; ?></h4>
        <h4>Nro de salas: <?php echo $cines->salasCine; ?></h4>         
        <h4>telefono: <?php echo $cines->telefonoCine; ?></h4>
        <a href="<?php echo RUTA_URL; ?>paginas/editarCine/<?php  echo $cines->idcines;?>"><p><button id="editar">Editar</button></p></a>
        <a href="<?php echo RUTA_URL; ?>paginas/borrarCine/<?php  echo $cines->idcines.'/'.$cines->nombreCine;?>"><p><button id="editar">Eliminar</button></p></a>
      </div>
    </div>
    <?php endforeach;?>
  </div>
  
  
  
</div>

<?php require RUTA_APP.'/vistas/inc/footer.php'; ?>