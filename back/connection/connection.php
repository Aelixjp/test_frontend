<?php
	
	//Connection function.
	function connect($host,$DB,$user,$pass){

		try {
			
			$conexion = new PDO("mysql:host=$host;dbname=$DB;charset = UTF-8",$user,$pass);
			return $conexion;
			
		} catch (PDOException $e) {
			$error = $e->getMessage();
			return false;
		}

	}

?>