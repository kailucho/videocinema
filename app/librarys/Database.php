<?php 
	//clase para conectarse a la base de datos y ejecutar consultas PDO
	/**
	 * 
	 */
	class Database{
		private $host = DB_HOST;
		private $usuario = DB_USER;
		private $password = DB_PASSWORD;
		private $nombre = DB_NAME;

		//database handler
		private $dbh;
		//statment consulta
		private $stmt;
		private $error;

		public function __construct(){
			//configurar conexion
			$dsn = 'mysql:host='.$this->host.';dbname='.$this->nombre;
			$opciones = array(
				PDO::ATTR_PERSISTENT => true,
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			);

			//CREAR UNA INSTANCIA DE PDO
			try {
				$this->dbh = new PDO($dsn,$this->usuario,$this->password, $opciones);
				$this->dbh->exec('set names utf8');
			} catch (PDOException $e) {
				$this->error = $e->getMessage();
				echo $this->error;
			}
		}

		//preparamos la onsulta
		public function query($sql){
			$this->stmt = $this->dbh->prepare($sql);
		}

		//vinculamos la consulta con bind
		public function bind($parametro,$valor,$tipo=null){
			if (is_null($tipo)) {
				switch (true) {
					case is_int($valor):
						$tipo = PDO::PARAM_IN;
						# code...
						break;
					case is_bool($valor):
						$tipo = PDO::PARAM_BOOL;
						# code...
						break;
					case is_null($valor):
						$tipo = PDO::PARAM_NULL;
						# code...
						break;
					
					
					default:
						$tipo = PDO::PARAM_STR;
						# code...
						break;
				}
				# code...
			}
			$this->stmt->bindValue($parametro, $valor,$tipo);
		}

		//ejecuta la consulta
		public function execute(){
			return $this->stmt->execute();			
		}

		//obtener los registros 
		public function registros(){
			$this->execute();
			return $this->stmt->fetchAll(PDO::FETCH_OBJ);
		}

		//obtener un solo registro
		public function registro(){
			$this->execute();
			return $this->stmt->fetch(PDO::FETCH_OBJ);
		}

		//obtener cantidad de filas con el metodo rowcon
		public function rowCount(){
			return $this->stmt->rowCount();
		}

		//ejecuta la consulta
		public function execute_id(){
			$this->stmt->execute();				
			$last_id = $this->dbh->lastInsertId();
			return $last_id;
		}

		
	}
 ?>