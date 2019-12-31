<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=conamatp_pointofsale",
			            "conamatp_pos",
			            "Zionzoo24#");

		$link->exec("set names utf8");

		return $link;

	}

}