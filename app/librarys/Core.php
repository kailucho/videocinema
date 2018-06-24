<?php 
	/*mapear la url ingresa en el navegador,
	1 controladr
	2 metodo
	3 parametro
	ejemplo /articulos/actualiar/4
	*/

	class Core{
		protected $controladorActual ='Paginas';
		protected $metodoActual = 'index';
		protected $parametros = [];
		//constructor
		public function __construct(){
			//print_r($this->getUrl());
			$url = $this->getUrl();

			//buscar en controladores si el controlador existe
			if (file_exists("../app/controllers/".ucwords($url[0]).'.php')) {
				// si existe se setea como controlador por defecto
				$this->controladorActual = ucwords($url[0]);

				//unset indice
				unset($url[0]);
			}

			//requerir el controlador
			require_once '../app/controllers/'.$this->controladorActual.'.php';
			$this->controladorActual = new $this->controladorActual;



			//chquear la segunda parte de la url que seria el metodo
			if (isset($url[1])) {
				if(method_exists($this->controladorActual,$url[1])){
					//chequemos el metodo
					$this->metodoActual = $url[1];
					//unset indice
					unset($url[1]);
				}
			}
			//para probar traer metodo
			//echo $this->metodoActual;

			//obtenerlos parametros
			$this->parametros = $url ? array_values($url) : [];

			//llamar callback con parametros array
			call_user_func_array([$this->controladorActual,$this->metodoActual], $this->parametros);
		}

		public function getUrl(){
			//echo $_GET['url'];

			if (isset($_GET['url'])) {
				
				$url = rtrim($_GET['url'],'/');
				
				$url = filter_var($url,FILTER_SANITIZE_URL);
				
				$url = explode('/',$url);
				return $url;
				
			}
		}
	}
 ?>