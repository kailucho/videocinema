<?php 
	class Usuario{
		private $db;

		public function __construct(){
			$this->db = new Database;
		}

		public function agregarUsuario($datos){
			$this->db->query('INSERT INTO usuarios (nombre,email,password,tipo)values(:nombre,:email,:password,1)');

			//vincular valores
			$this->db->bind(':nombre',$datos['nombre']);
			$this->db->bind(':email',$datos['email']);
			$this->db->bind(':password',$datos['password']);

			//ejecutar
			if($this->db->execute()){
				return true;
			}else{
				return false;
			}
			
			
		}

		public function obtenerNombre($datos){
			$this->db->query('SELECT nombre,tipo,idusuarios FROM usuarios WHERE email = :email AND password = :password');
			$this->db->bind(':email',$datos['email']);
			$this->db->bind(':password',$datos['password']);
			$fila = $this->db->registro();
			if ( $this->db->rowCount()>0) {
				return $fila;
			}else{
				return NULL;
			}

			
		}

		public function agregarCine($datos){
			$this->db->query('INSERT INTO cines (usuarios_idusuarios,nombreCine,descripcionCine,horarioCine,logoCine,salasCine,direccionCine,latitudCine,longitudCine,telefonoCine)values(:usuarios_idusuarios,:nombreCine,:descripcionCine,:horarioCine,:logoCine,:salasCine,:direccionCine,:latitudCine,:longitudCine,:telefonoCine)');
			//print_r($_SESSION['id']);
			//vincular valores
			$this->db->bind(':usuarios_idusuarios',$_SESSION['id']);
			$this->db->bind(':nombreCine',$datos['nombreCine']);
			$this->db->bind(':descripcionCine',$datos['descripcionCine']);
			$this->db->bind(':horarioCine',$datos['horarioCine']);
			$this->db->bind(':logoCine',$datos['nombreCine'].".JPG");
			$this->db->bind(':salasCine',$datos['salasCine']);
			$this->db->bind(':direccionCine',$datos['direccionCine']);
			$this->db->bind(':latitudCine',$datos['latitudCine']);
			$this->db->bind(':longitudCine',$datos['longitudCine']);
			$this->db->bind(':telefonoCine',$datos['telefonoCine']);


			//ejecutar
			if($this->db->execute()){
				return true;
			}else{
				return false;
			}
			
			
		}

		public function obtenerCinesUsuario($id){
			$this->db->query('SELECT*FROM cines WHERE usuarios_idusuarios = :id ');
			$this->db->bind(':id',$id);
			$resultados = $this->db->registros();

			return $resultados;
		}

		public function obtenerCines(){
			$this->db->query('SELECT*FROM cines');
			$resultados = $this->db->registros();

			return $resultados;
		}

		public function obtenerCine($idCine){
			$this->db->query('SELECT*FROM cines WHERE :idcine =idcines');
			$this->db->bind(':idcine',$idCine);

			$resultados = $this->db->registro();

			return $resultados;
		}

		public function actualizarCine($datos){
			$this->db->query('UPDATE cines SET nombreCine = :nombreCine, descripcionCine = :descripcionCine, horarioCine = :horarioCine, salasCine = :salasCine, direccionCine = :direccionCine, latitudCine = :latitudCine, longitudCine = :longitudCine, telefonoCine = :telefonoCine WHERE idcines = :idCine');

			//vincular valores
			$this->db->bind(':idCine',$datos['idCine']);
			$this->db->bind(':nombreCine',$datos['nombreCine']);
			$this->db->bind(':descripcionCine',$datos['descripcionCine']);
			$this->db->bind(':horarioCine',$datos['horarioCine']);
			$this->db->bind(':salasCine',$datos['salasCine']);
			$this->db->bind(':direccionCine',$datos['direccionCine']);
			$this->db->bind(':latitudCine',$datos['latitudCine']);
			$this->db->bind(':longitudCine',$datos['longitudCine']);
			$this->db->bind(':telefonoCine',$datos['telefonoCine']);

			//ejecutar
			if($this->db->execute()){
				return true;
			}else{
				return false;
			}
		}

		public function borrarCine($cines_idcines){
			
			print_r("borrando cine");
			$this->db->query('DELETE FROM cines WHERE idcines = :cines_idcines');
			$this->db->bind(':cines_idcines',$cines_idcines);
			return $this->db->execute();
				
		}

		public function obtenerPeliculas($idCines){
			$_SESSION['idCine'] = $idCines;
			$this->db->query('SELECT*FROM peliculas WHERE :idCines =cines_idcines');
			$this->db->bind(':idCines',$idCines);

			$resultados = $this->db->registros();
			
			foreach ($resultados as $key => $value) {
				//*******************GENEROS***********************************//
				//se consigue los idgeneros relacinaos a la pelicula
				$this->db->query('SELECT generos_idgeneros FROM generos_has_peliculas WHERE peliculas_idpeliculas =:peliculas_idpeliculas');
				$this->db->bind(':peliculas_idpeliculas',$value->idpeliculas);
				$idgeneros = $this->db->registros();
				
				//se consigue los nombres de los idgeneros
				$array = array();
				foreach ($idgeneros as $key2) {
					
					$idgen =$key2->generos_idgeneros;
					$this->db->query('SELECT nombreGeneros FROM generos WHERE idgeneros = :idgeneros');
					$this->db->bind(':idgeneros',$idgen);
					$nombreGeneros = $this->db->registro();
					$array[] = $nombreGeneros->nombreGeneros;	
				}
				$resultados[$key]->generosPelicula = $array;
				
				//*******************DIRECTORES***********************************//

				//se consigue los idgeneros relacinaos a la pelicula
				$this->db->query('SELECT directores_iddirectores FROM directores_has_peliculas WHERE peliculas_idpeliculas =:peliculas_idpeliculas');
				$this->db->bind(':peliculas_idpeliculas',$value->idpeliculas);
				$idpeliculas = $this->db->registros();
				
				//se consigue los nombres de los idgeneros
				$array = array();
				foreach ($idpeliculas as $key2) {
					
					$iddir =$key2->directores_iddirectores;
					$this->db->query('SELECT nombreDirectores FROM directores WHERE iddirectores = :iddirectores');
					$this->db->bind(':iddirectores',$iddir);
					$nombreDirectores = $this->db->registro();
					$array[] = $nombreDirectores->nombreDirectores;	
				}
				$resultados[$key]->directoresPelicula = $array;

				//*******************ACTORES***********************************//

				//se consigue los idgeneros relacinaos a la pelicula
				$this->db->query('SELECT actores_idactores FROM actores_has_peliculas WHERE peliculas_idpeliculas =:peliculas_idpeliculas');
				$this->db->bind(':peliculas_idpeliculas',$value->idpeliculas);
				$idpeliculas = $this->db->registros();
				
				//se consigue los nombres de los idgeneros
				$array = array();
				foreach ($idpeliculas as $key3) {
					
					$iddir =$key3->actores_idactores;
					$this->db->query('SELECT nombreActor FROM actores WHERE idactores = :idactores');
					$this->db->bind(':idactores',$iddir);
					$nombreActores = $this->db->registro();
					//print_r($nombreActores);
					$array[] = $nombreActores->nombreActor;	
				}
				$resultados[$key]->actoresPelicula = $array;
				
			}			
			//print_r($resultados);
			return $resultados;
		}

		public function obtenerPelicula($idpelicula){

			$this->db->query('SELECT*FROM peliculas WHERE :idpeliculas =idpeliculas');
			$this->db->bind(':idpeliculas',$idpelicula);

			$resultados = $this->db->registros();
			
			foreach ($resultados as $key => $value) {
				//*******************GENEROS***********************************//
				//se consigue los idgeneros relacinaos a la pelicula
				$this->db->query('SELECT generos_idgeneros FROM generos_has_peliculas WHERE peliculas_idpeliculas =:peliculas_idpeliculas');
				$this->db->bind(':peliculas_idpeliculas',$value->idpeliculas);
				$idgeneros = $this->db->registros();
				
				//se consigue los nombres de los idgeneros
				$array = array();
				foreach ($idgeneros as $key2) {
					
					$idgen =$key2->generos_idgeneros;
					$this->db->query('SELECT nombreGeneros FROM generos WHERE idgeneros = :idgeneros');
					$this->db->bind(':idgeneros',$idgen);
					$nombreGeneros = $this->db->registro();
					$array[] = $nombreGeneros->nombreGeneros;	
				}
				$resultados[$key]->generosPelicula = $array;
				
				//*******************DIRECTORES***********************************//

				//se consigue los idgeneros relacinaos a la pelicula
				$this->db->query('SELECT directores_iddirectores FROM directores_has_peliculas WHERE peliculas_idpeliculas =:peliculas_idpeliculas');
				$this->db->bind(':peliculas_idpeliculas',$value->idpeliculas);
				$iddirectores = $this->db->registro();
				
				
				//se consigue los nombres de los diretores
				$this->db->query('SELECT nombreDirectores FROM directores WHERE iddirectores = :iddirectores');
				$this->db->bind(':iddirectores',$iddirectores->directores_iddirectores);
				$nombreDirectores = $this->db->registro();
				
				
				
				$resultados[$key]->directoresPelicula = $nombreDirectores;

				//*******************ACTORES***********************************//

				//se consigue los idgeneros relacinaos a la pelicula
				$this->db->query('SELECT actores_idactores FROM actores_has_peliculas WHERE peliculas_idpeliculas =:peliculas_idpeliculas');
				$this->db->bind(':peliculas_idpeliculas',$value->idpeliculas);
				$idpeliculas = $this->db->registros();
				
				//se consigue los nombres de los idgeneros
				$array = array();
				foreach ($idpeliculas as $key3) {
					
					$iddir =$key3->actores_idactores;
					$this->db->query('SELECT nombreActor FROM actores WHERE idactores = :idactores');
					$this->db->bind(':idactores',$iddir);
					$nombreActores = $this->db->registro();
					//print_r($nombreActores);
					$array[] = $nombreActores->nombreActor;	
				}
				$resultados[$key]->actoresPelicula = $array;
				
			}			
			//print_r($resultados);
			return $resultados;
		}

		public function agregarPelicula($datosPelicula){
			//ingresando en tabla peliculas
			$this->db->query("INSERT INTO peliculas (cines_idcines,nombrePelicula,descripcionPelicula, anyoPelicula, duracionPelicula,imagenPelicula) VALUES(:cines_idcines,:nombrePelicula,:descripcionPelicula,:anyoPelicula, :duracionPelicula,:imagenPelicula)");

			$this->db->bind(':cines_idcines',$datosPelicula['idCine']);
			$this->db->bind(':nombrePelicula',$datosPelicula['nombrePelicula']);
			$this->db->bind(':descripcionPelicula',$datosPelicula['descripcionPelicula']);
			$this->db->bind(':anyoPelicula',$datosPelicula['anyoPelicula']);
			$this->db->bind(':duracionPelicula',$datosPelicula['duracionPelicula']);
			$this->db->bind(':imagenPelicula',$datosPelicula['nombrePelicula'].".JPG");
			$idPelicula = $this->db->execute_id();

			//ingresando director

			$this->db->query("SELECT * FROM directores WHERE nombreDirectores = :nombreDirectores");
			$this->db->bind(':nombreDirectores',$datosPelicula['directorPelicula']);
			$registros = $this->db->registros();
			$rows = $this->db->rowCount();
			$idDirector = $registros[0]->iddirectores;

			if($rows == 0){
				//echo "insertando";
				$this->db->query("INSERT INTO directores(nombreDirectores) VALUES (:nombreDirectores)");
				$this->db->bind(':nombreDirectores',$datosPelicula['directorPelicula']);
				$idDirector = $this->db->execute_id();					
			}			
			//ingresando en tabla directores_has_peliculas
			$this->db->query("INSERT INTO directores_has_peliculas(directores_iddirectores,peliculas_idpeliculas) VALUES (:directores_iddirectores,:peliculas_idpeliculas)");
			$this->db->bind(':directores_iddirectores',$idDirector);
			$this->db->bind(':peliculas_idpeliculas',$idPelicula);
			$this->db->execute();	

			//ingresando acctores
			foreach ($datosPelicula['nombreActor'] as $key => $value) {

				$this->db->query("SELECT * FROM actores WHERE nombreActor = :nombreActor");
				$this->db->bind(':nombreActor',$value);
				$registros = $this->db->registros();
				$rows = $this->db->rowCount();
				$idActor = $registros[0]->idactores;

				if($rows == 0){
					//echo "insertando";
					$this->db->query("INSERT INTO actores(nombreActor) VALUES (:nombreActor)");
					$this->db->bind(':nombreActor',$value);
					$idActor = $this->db->execute_id();				
					
				}

				//ingresando en tabla actores_has_peliculas
				$this->db->query("INSERT INTO actores_has_peliculas(actores_idactores,peliculas_idpeliculas) VALUES (:actores_idactores,:peliculas_idpeliculas)");
				$this->db->bind(':actores_idactores',$idActor);
				$this->db->bind(':peliculas_idpeliculas',$idPelicula);
				$this->db->execute();
							
			}

			//ingresando generos
			foreach ($datosPelicula['nombreGenero'] as $key => $value) {

				$this->db->query("SELECT * FROM generos WHERE nombreGeneros = :nombreGeneros");
				$this->db->bind(':nombreGeneros',$value);
				$registros = $this->db->registros();
				$rows = $this->db->rowCount();
				$idGenero = $registros[0]->idgeneros;

				if($rows == 0){
					//echo "insertando";
					$this->db->query("INSERT INTO generos(nombreGeneros) VALUES (:nombreGeneros)");
					$this->db->bind(':nombreGeneros',$value);
					$idGenero = $this->db->execute_id();				
					
				}								
				//ingresando en tabla actores_has_peliculas
				$this->db->query("INSERT INTO generos_has_peliculas(generos_idgeneros,peliculas_idpeliculas) VALUES (:generos_idgeneros,:peliculas_idpeliculas)");
				$this->db->bind(':generos_idgeneros',$idGenero);
				$this->db->bind(':peliculas_idpeliculas',$idPelicula);
				$this->db->execute();				
			}

			
			return true;
		}
		public  function actualizarPelicula($datos){
			//actualizando en tabla peliculas
			$this->db->query("UPDATE peliculas SET nombrePelicula = :nombrePelicula,descripcionPelicula = :descripcionPelicula, anyoPelicula = :anyoPelicula, duracionPelicula = :duracionPelicula WHERE idpeliculas = :idpeliculas");

			$this->db->bind(':idpeliculas',$datos['idpeliculas']);
			$this->db->bind(':nombrePelicula',$datos['nombrePelicula']);
			$this->db->bind(':descripcionPelicula',$datos['descripcionPelicula']);
			$this->db->bind(':anyoPelicula',$datos['anyoPelicula']);
			$this->db->bind(':duracionPelicula',$datos['duracionPelicula']);			
			$this->db->execute();
			$idPelicula = $datos['idpeliculas'];

			//actualizando director
			echo "actualizando director <br>";

			$this->db->query('SELECT directores_iddirectores FROM directores_has_peliculas WHERE peliculas_idpeliculas =:peliculas_idpeliculas');
			$this->db->bind(':peliculas_idpeliculas',$idPelicula);
			$idDirector = $this->db->registro();

			$this->db->query("UPDATE directores SET nombreDirectores = :nombreDirectores WHERE  iddirectores = :iddirectores");
			$this->db->bind(':iddirectores',$idDirector->directores_iddirectores);
			$this->db->bind(':nombreDirectores',$datos['directorPelicula']);
			$this->db->execute();
			
			
			echo "actualizando actores";
			//actualizando acctores
			foreach ($datos['nombreActor'] as $key => $value) {
				$this->db->query("SELECT * FROM actores WHERE nombreActor = :nombreActor");
				$this->db->bind(':nombreActor',$value);
				$this->db->registros();
				$rows = $this->db->rowCount();
				echo "<br>";
				echo $value." ".$rows;
				echo "<br>";
				if($rows == 0){
					echo "insertando";
					$this->db->query("INSERT INTO actores(nombreActor) VALUES (:nombreActor)");
					$this->db->bind(':nombreActor',$value);
					$idActor = $this->db->execute_id();				
					//ingresando en tabla actores_has_peliculas
					$this->db->query("INSERT INTO actores_has_peliculas(actores_idactores,peliculas_idpeliculas) VALUES (:actores_idactores,:peliculas_idpeliculas)");
					$this->db->bind(':actores_idactores',$idActor);
					$this->db->bind(':peliculas_idpeliculas',$idPelicula);
					$this->db->execute();
				}
				

			}
			

			//ingresando generos
			foreach ($datos['nombreGenero'] as $key => $value) {
				$this->db->query("SELECT * FROM generos WHERE nombreGeneros = :nombreGeneros");
				$this->db->bind(':nombreGeneros',$value);
				$this->db->registros();
				$rows = $this->db->rowCount();
				echo "<br>";
				echo $value." ".$rows;
				echo "<br>";
				if($rows == 0){

					$this->db->query("INSERT INTO generos(nombreGeneros) VALUES (:nombreGeneros)");
					$this->db->bind(':nombreGeneros',$value);
					$idGenero = $this->db->execute_id();				
					//ingresando en tabla actores_has_peliculas
					$this->db->query("INSERT INTO generos_has_peliculas(generos_idgeneros,peliculas_idpeliculas) VALUES (:generos_idgeneros,:peliculas_idpeliculas)");
					$this->db->bind(':generos_idgeneros',$idGenero);
					$this->db->bind(':peliculas_idpeliculas',$idPelicula);
					$this->db->execute();
				}	
			}
			return true;
		}

		public function borrarPelicula($idpeliculas){

			print_r("borrando pelicula");
			$this->db->query('DELETE FROM peliculas WHERE idpeliculas = :idpeliculas');
			$this->db->bind(':idpeliculas',$idpeliculas);
			return $this->db->execute();
				
		}
	}	


 ?>