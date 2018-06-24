<?php 

	session_start();
	//cargamos librerias
	require_once 'config/Configurar.php';

	require_once 'helpers/url_helper.php';
	//require_once 'librarys/Database.php';
	//require_once 'librarys/controlador.php';
	//require_once 'librarys/core.php';


	//autoload php
	spl_autoload_register(function($nombreClase){
		require_once 'librarys/'.$nombreClase.'.php';
	})
	
 ?>