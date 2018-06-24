 <?php require RUTA_APP.'/vistas/inc/header_admin.php'; ?>
<style>
	table {
	    border-collapse: collapse;
	    border-spacing: 0;
	    width: 100%;
	    border: 1px solid #ddd;
	}

	th, td {
	    text-align: left;
	    padding: 8px;
	}

	tr:nth-child(even){background-color: #f2f2f2}
</style>
<a href="<?php echo RUTA_URL; ?>paginas/agregarPelicula/<?php  echo $datos['cine'];?>"> AGREGAR</a>
<div style="overflow-x:auto;">
	<table >
	
		<tr>
			<th>ID</th>
			<th>Nombre</th>
			<th>Descripcion</th>
			<th>Año</th>
			<th>Generos</th>
			<th>Directores</th>
			<th>Actores</th>
			<th colspan="2">Acciones</th>	
		</tr>
		
	
		<?php foreach($datos['peliculas'] as $pelicula) :?>
	
		<tr>
			<td><?php echo $pelicula->idpeliculas; ?></td>
			<td><?php echo $pelicula->nombrePelicula; ?></td>
			<td><?php echo $pelicula->descripcionPelicula; ?></td>
			<td><?php echo $pelicula->anyoPelicula; ?></td>
			<td>
				<?php foreach ($pelicula->generosPelicula as $key) {
					echo $key;	
					echo " ";
				} ?>
				
			</td>
			<td>
				<?php foreach ($pelicula->directoresPelicula as $key) {
					echo $key;	
					echo " ";
				} ?>
				
			</td>
			<td>
				<?php foreach ($pelicula->actoresPelicula as $key) {
					echo $key;	
					echo " ";
				} ?>
				
			</td>
			<td><a href="<?php echo RUTA_URL; ?>paginas/editarPelicula/<?php  echo $pelicula->idpeliculas;?>"> Editar</a></td>
			<td><a href="<?php echo RUTA_URL; ?>paginas/borrarPelicula/<?php  echo $pelicula->idpeliculas;?>"> Borrar</a></td>
		</tr>
		<?php endforeach;?>
	
	</table>
</div>


<?php require RUTA_APP.'/vistas/inc/footer.php'; ?>