<?php require RUTA_APP.'/vistas/inc/header_user.php'; ?>
<div class="container">
  <h2>REGISTRO DE USUARIO</h2>
  <form action="<?php echo RUTA_URL; ?>paginas/registrar/" method='POST'>
  	<div class="form-group">
      <label for="pwd">Usuario:</label>
      <input type="text" class="form-control" id="pwd" placeholder="Ingresa Nombre de Usuario" name="user" >
    </div>
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Ingresa tu correo" name="email" >
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Ingresa tu contrasenia" name="pswd"  ">
    </div>	    
    
    <button type="submit" class="btn btn-primary">Registrarse</button>
  </form>
</div>
















<?php require RUTA_APP.'/vistas/inc/footer.php'; ?>