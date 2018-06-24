<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="<?php echo RUTA_URL ?>/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo RUTA_URL ?>/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <title><?php echo NOMBRESITIO; ?></title> 
  <style>
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;        
        background-color: #FAFAFA;
        
    }
  </style>
</head>
<body>
<nav class="navbar navbar-inverse">
  <div class="navbar-header">
  <a class="navbar-brand" href="#"><?php echo $_SESSION['user']; ?></a>
    
      
  
   
      <a class="navbar-brand" href="<?php echo RUTA_URL; ?>paginas/infoCine/">infoCine</a>
  

      <a class="navbar-brand" href="<?php echo RUTA_URL; ?>paginas/salas/">SALAS</a>
  
      <a class="navbar-brand" href="<?php echo RUTA_URL; ?>paginas/cerrarSesion/">Cerrar Sesion</a>    
  
  </div>
</nav>

