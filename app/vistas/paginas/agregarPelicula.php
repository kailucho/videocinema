<?php require RUTA_APP.'/vistas/inc/header_admin.php'; ?>
<!--<a href="javascript:history.back(-1);" title="Ir la página anterior">regresar</a>-->

<div class="row">
  <div class="col-75">
    <div class="container">
      <form method="post" enctype="multipart/form-data" action="<?php echo RUTA_URL; ?>paginas/agregarPelicula/<?php echo $datos ?>"> 
        <div class="row">
          <div class="col-50">
            <h3>DATOS DE PELICULA</h3>
            <label for="fname"><i class="fa fa-user"></i> Nombre de la pelicula</label>
            <input type="text" name="nombrePelicula">
            
            <label for="fname"><i class="fa fa-user"></i> Descripcion</label>
            <input type="text" name="descripcionPelicula">

            <div class="row">
              <div class="col-25">
                <label for="fname"><i class="fa fa-user"></i> Año de estreno</label>
                <input type="text" name="anyoPelicula">
              </div>
              <div class="col-25">
                  <label for="fname"><i class="fa fa-user"></i> Duracion</label>
                  <input type="text" name="duracionPelicula">
              </div>
              <div class="col-25">
                
                <label for="fname"><i class="fa fa-user"></i> Imagen</label>
                <input type="file" name="imagenPelicula">
              </div>         
            </div>

            <label for="fname"><i class="fa fa-user"></i> Director</label>
            <input type="text" name="directorPelicula">
            
          
            <label for="fname">
              <i class="fa fa-user"></i> Generos 
              <input type="button" onclick="add_genero();" value="Agregar genero">
              <input type="button" onclick="delete_genero();" value="Eliminar genero">
            </label>

            <div class="row" id="generos">
              <div class="col-25" id="row1">
                <input  type="text" name="nombreGenero[]"> 
              </div>                        
            </div>  
          
                       
                  

            

            <label for="fname">
              <i class="fa fa-user"></i> Actores 
              <input type="button" onclick="add_actor();" value="Agregar actor">
              <input type="button" onclick="delete_actor();" value="Eliminar actor">
            </label>
             <div class="row" id="actores">
              <div class="col-25" id="acno1">
                <input  type="text" name="nombreActor[]"> 
              </div>                        
            </div>  
            
          </div>        
          
        </div>
        <input type="submit">
      </form>
    </div>
  </div>  
</div>
<script src="<?php echo(RUTA_URL) ?>/js/jquery-3.2.1.min.js"></script> 
<script type="text/javascript">
function add_genero()
{
  
 $rowno=$("#generos :input").length
 console.log($rowno);
 $rowno=$rowno+1;
 console.log($rowno);
 $("#generos").append(
  "<div class='col-25' id='row"+$rowno+"'>"+
  "<input type='text' name='nombreGenero[]'> "+
  "</div>");
}
function delete_genero()
{
  $rowno=$("#generos :input").length;
  if($rowno > 1){
    $rowno="row"+$rowno;
    console.log($rowno);
  
    $('#'+$rowno).remove();  
  }
  
}

function add_actor()
{
  
 $acno=$("#actores :input").length
 console.log($acno);
 $acno=$acno+1;
 console.log($acno);
 $("#actores").append(
  "<div class='col-25' id='acno"+$acno+"'>"+
  "<input type='text' name='nombreActor[]'> "+
  "</div>");

}
function delete_actor()
{
  $acno=$("#actores :input").length;
  if($acno > 1){
    $acno="acno"+$acno;
    console.log($acno);
    $('#'+$acno).remove();
  }
}
</script>



<?php require RUTA_APP.'/vistas/inc/footer.php'; ?>
