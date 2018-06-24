<?php require RUTA_APP.'/vistas/inc/header_user.php'; ?>




<div class="container">
  <h2>Stacked form</h2>
  <form action="<?php echo RUTA_URL; ?>paginas/login/" method='POST'>

    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pswd">
    </div>	
    <!--<div class="form-group form-check">
      <label class="form-check-label">
        <input class="form-check-input" type="checkbox" name="remember"> Remember me
      </label>
    </div>-->
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</div>







<?php require RUTA_APP.'/vistas/inc/footer.php'; ?>