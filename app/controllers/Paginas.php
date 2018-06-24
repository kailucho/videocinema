<?php 
	
	class Paginas extends Controlador{
		public function __construct(){		
			$this->usuarioModelo = $this->modelo('Usuario')	;
		}

		public function index(){
			$cines = $this->usuarioModelo->obtenerCines();

			$datos = [
			'cines' => $cines
			];
			//print_r($datos);
			$this->vista('paginas/cines',$datos);
		}
		//***********************************************//
		public function registrar(){
			if ($_SERVER['REQUEST_METHOD']=='POST') {
				$datos = [
					'nombre' => trim($_POST['user']),
				'email' => trim($_POST['email']),
				'password' => trim($_POST['pswd'])
				];
				

				if ($this->usuarioModelo->agregarUsuario($datos)) {

					$usuario = $this->usuarioModelo->obtenerNombre($datos);
				
					if(isset($usuario)){
						$_SESSION['user'] = $usuario->nombre;
						$_SESSION['tipo'] = $usuario->tipo;		
						$_SESSION['id'] = $usuario->idusuarios;
						$this->vista('paginas/infoCine');
					}else{
						$this->vista('paginas/login');
					}

					redireccionar('paginas/infoCine');
					# code...
				}else{
					die('ALGO SALIO MAL');
				}
				# code...
			}else{
				$datos = [
					'nombre' => '',
					'email' => '',
					'password' =>''
				];

				$this->vista('paginas/registro',$datos);

			}
			
		}
		public function login(){
			if ($_SERVER['REQUEST_METHOD']=='POST') {
				$datos = [					
					'email' => trim($_POST['email']),
					'password' => trim($_POST['pswd'])
				];
				$usuario = $this->usuarioModelo->obtenerNombre($datos);
				//print_r($usuario);
				if(isset($usuario)){
					$_SESSION['user'] = $usuario->nombre;
					$_SESSION['tipo'] = $usuario->tipo;		
					$_SESSION['id'] = $usuario->idusuarios;	
					redireccionar('paginas/infoCine');
				}else{
					redireccionar('paginas/login');
				}
				

				# code...
			}else{
				$datos = [
					'email' => '',
					'password' => ''
				];

				$this->vista('paginas/login',$datos);

			}
		}

		public function cerrarSesion(){
			session_destroy();			
			redireccionar('paginas/login');
		}
		//***********************************************//
		
		public function cines(){
			$cines = $this->usuarioModelo->obtenerCines();

			$datos = [
			'cines' => $cines
			];
			//print_r($datos);
			$this->vista('paginas/cines',$datos);
			
		}

		public function infoCine(){
			if(isset($_SESSION['tipo'])){
				$cines = $this->usuarioModelo->obtenerCinesUsuario($_SESSION['id']);
				

				$datos = [
				'cines' => $cines
				];
				//print_r($datos);
				$this->vista('paginas/infoCine',$datos);
				
			}else{
				redireccionar('paginas/login');
			}
		}
		public function agregarCine(){
			if(isset($_SESSION['tipo'])){
				if ($_SERVER['REQUEST_METHOD']=='POST') {
					$datos = [						
						'nombreCine' => trim($_POST['nombreCine']),
						'direccionCine' => trim($_POST['direccionCine']),	
						'descripcionCine' => trim($_POST['descripcionCine']),
						'horarioCine' =>trim($_POST['horarioCine']),				
						'salasCine'=>trim($_POST['salasCine']),
						'telefonoCine'=>trim($_POST['telefonoCine']),
						'latitudCine'=>trim($_POST['latitudCine']),
						'longitudCine'=>trim($_POST['longitudCine'])				
					];				

					if ($this->usuarioModelo->agregarCine($datos)) {

						$title = $_SESSION['id'].$_POST["nombreCine"];
						$nombre_archivo = $_FILES["logoCine"]["tmp_name"];
						// Obtener dimensiones iniciales
						list($ancho, $alto) = getimagesize($nombre_archivo);
						$nuevo_ancho = 1000;
						$nuevo_alto = 600;

						// Redimensionar
						$imagen_p = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
						$imagen = imagecreatefromjpeg($nombre_archivo);
						imagecopyresampled($imagen_p, $imagen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);
						// Imprimir
						if(!imagejpeg($imagen_p, RUTA_URL2."/public/img/".$title.".JPG", 100))
						{
							echo "no se pudo guardar la imagen";
						}

						redireccionar('paginas/infoCine');

						
						# code...
					}else{
						die('ALGO SALIO MAL');
					}
					# code...
				}else{
					$this->vista('paginas/agregarCine');		
				}

				
			}else{
				redireccionar('paginas/login');	
			}
		}

		public function editarCine($id){
			if ($_SERVER['REQUEST_METHOD']=='POST') {			
				
				$datos = [
					'idCine' => $id,
					'nombreCine' => trim($_POST['nombreCine']),
					'direccionCine' => trim($_POST['direccionCine']),
					'descripcionCine' => trim($_POST['descripcionCine']),
					'horarioCine' => trim($_POST['horarioCine']),
					'salasCine' => trim($_POST['salasCine']),
					'telefonoCine' => trim($_POST['telefonoCine']),
					'longitudCine' => trim($_POST['longitudCine']),
					'latitudCine' => trim($_POST['latitudCine'])
				];
				

				if ($this->usuarioModelo->actualizarCine($datos)) {
					$nombre_archivo = $_FILES["logoCine"]["tmp_name"];
					if ($nombre_archivo!='') {
						$title = $_SESSION['id'].$_POST["nombreCine"];
						echo "guardando imagen";
						echo $nombre_archivo;
						// Obtener dimensiones iniciales
						list($ancho, $alto) = getimagesize($nombre_archivo);
						$nuevo_ancho = 1000;
						$nuevo_alto = 600;

						// Redimensionar
						$imagen_p = imagecreatetruecolor($nuevo_ancho, $nuevo_alto);
						$imagen = imagecreatefromjpeg($nombre_archivo);
						imagecopyresampled($imagen_p, $imagen, 0, 0, 0, 0, $nuevo_ancho, $nuevo_alto, $ancho, $alto);
						// Imprimir
						if(!imagejpeg($imagen_p, RUTA_URL2."/public/img/".$title.".JPG", 100))
						{
							echo "no se pudo guardar la imagen";
						}
					}else{
						echo "archivo vacio ";

					}
					echo "fin";
					redireccionar('paginas/infoCine');
					# code...
				}else{
					die('ALGO SALIO MAL');
				}
				# code...
			}else{
				//obtener informacion de usuario desde el modelo

				$cine = $this->usuarioModelo->obtenerCine($id);
				

				$datos = [
					'idCine' => $cine->idcines,
					'logoCine' => $cine->logoCine,
					'nombreCine' => $cine->nombreCine,
					'direccionCine' => $cine->direccionCine,
					'descripcionCine' => $cine->descripcionCine,
					'horarioCine' => $cine->horarioCine,
					'salasCine' => $cine->salasCine,
					'telefonoCine' => $cine->telefonoCine,
					'longitudCine' => $cine->longitudCine,
					'latitudCine' => $cine->latitudCine
					
				];

				$this->vista('paginas/editarCine',$datos);

			}
		}

		public function borrarCine($idCine,$nombreCine){
			if ($this->usuarioModelo->borrarCine($idCine)) {
				unlink(RUTA_URL2."/public/img/".$_SESSION['id'].$nombreCine.".jpg");
					redireccionar('paginas/infoCine');
					# code...
			}else{
				die('ALGO SALIO MAL');
			}
				# code...
		}
		//***********************************************//
		
		public function mostrarPeliculas($idCines){
			if(isset($_SESSION['tipo'])){
				
				$peliculas = $this->usuarioModelo->obtenerPeliculas($idCines);

				$datos = [
				'peliculas' => $peliculas,
				'cine' =>$idCines
				];

			$this->vista('paginas/peliculasCrud',$datos);	
			}else{
				redireccionar('paginas/login');	
			}
			
		}

		public function agregarPelicula($idCine){
			if(isset($_SESSION['tipo'])){
				if ($_SERVER['REQUEST_METHOD']=='POST') {
					$datos = [
						'idCine' => $idCine,	
						'nombrePelicula' => trim($_POST['nombrePelicula']),					
						'descripcionPelicula' => trim($_POST['descripcionPelicula']),
						'anyoPelicula' =>trim($_POST['anyoPelicula']),
						'duracionPelicula' => trim($_POST['duracionPelicula']),								
						'directorPelicula'=>trim($_POST['directorPelicula']),
						'nombreGenero'=>$_POST['nombreGenero'],
						'nombreActor'=>$_POST['nombreActor']					
					];				
					
					if ($this->usuarioModelo->agregarPelicula($datos)) {
						redireccionar('paginas/mostrarPeliculas/'.$idCine);
						# code...
					}else{
						die('ALGO SALIO MAL');
					}
					# code...
				}else{
					//echo $idCine;
					$this->vista('paginas/agregarPelicula',$idCine);		
				}

				
			}else{

				redireccionar('paginas/login');	
			}
		}
		
		

		public function editarPelicula($id){
			if ($_SERVER['REQUEST_METHOD']=='POST') {
				echo $id;
				$datos = [
					'idpeliculas' => $id,					
					'nombrePelicula' => trim($_POST['nombrePelicula']),					
					'descripcionPelicula' => trim($_POST['descripcionPelicula']),
					'anyoPelicula' =>trim($_POST['anyoPelicula']),
					'duracionPelicula' => trim($_POST['duracionPelicula']),								
					'directorPelicula'=>trim($_POST['directorPelicula']),
					'nombreGenero'=>$_POST['nombreGenero'],
					'nombreActor'=>$_POST['nombreActor']					
				];

				if ($this->usuarioModelo->actualizarPelicula($datos)) {
					redireccionar('paginas/mostrarPeliculas/'.$_SESSION['idCine']);
					# code...
				}else{
					die('ALGO SALIO MAL');
				}
				# code...
			}else{
				//obtener informacion de usuario desde el modelo
				
				$pelicula = $this->usuarioModelo->obtenerPelicula($id);
				

				$datos = [
					'idpelicula' => $pelicula[0]->idpeliculas,
					'nombrePelicula' => $pelicula[0]->nombrePelicula,
					'descripcionPelicula' => $pelicula[0]->descripcionPelicula,
					'anyoPelicula' => $pelicula[0]->anyoPelicula,
					'duracionPelicula' => $pelicula[0]->duracionPelicula,
					'imagenPelicula' => $pelicula[0]->imagenPelicula,
					'generosPelicula' => $pelicula[0]->generosPelicula,
					'directoresPelicula' => $pelicula[0]->directoresPelicula->nombreDirectores,
					'actoresPelicula' => $pelicula[0]->actoresPelicula
				];

				$this->vista('paginas/editarPelicula',$datos);

			}
		}

		public function borrarPelicula($id){
			if ($this->usuarioModelo->borrarPelicula($id)) {
				//unlink(RUTA_URL2."/public/img/".$_SESSION['id'].$nombreCine.".jpg");
				redireccionar('paginas/mostrarPeliculas/'.$_SESSION['idCine']);
					# code...
			}else{
				die('ALGO SALIO MAL');
			}
		}

		
//**********************************************//
		public function salas(){
			if(isset($_SESSION['tipo'])){
				$this->vista('paginas/salas');
			}else{
				redireccionar('paginas/login');
			}
		}

		
	}
 ?>
