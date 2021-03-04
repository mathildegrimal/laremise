<?php
class DB{

	private $host = 'mysql-laremise.alwaysdata.net';
	private $username = 'laremise';
	private $password = '';
	private $database = 'laremise_database';
	private $port='3306';
	private $db;

	public function __construct($host = null, $username = null, $password = null, $database = null, $port = null){
		if($host != null){
			$this->host = $host;
			$this->username = $username;
			$this->password = $password;
			$this->database = $database;
			$this->port = $port;
		}

		try{
			$this->db = new PDO('mysql:host='.$this->host.';dbname='.$this->database.';port='.$this->port, $this->username, $this->password, array(
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES UTF8',
					PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
				));
		}catch(PDOException $e){
			die('<h1>Impossible de se connecter a la base de donnee</h1>');
		}


	}

	public function query($sql, $data = array()){
		$req =$this->db->prepare($sql);
		$req->execute($data);
		return $req->fetchAll(PDO::FETCH_OBJ);
	}
	public function select1($sql, $data = array()){
		$req =$this->db->prepare($sql);
		$req->execute($data);
		return $req->fetch(PDO::FETCH_OBJ);
	}

	public function update($sql, $data = array()){
		$req =$this->db->prepare($sql);
		if ($req->execute($data))
			$res=true;
		else
			$res=false;
		return $res;
	}
	public function insert($sql, $data = array()){
		$req =$this->db->prepare($sql);
		if ($req->execute($data))
			$res=true;
		else
			$res=false;
		return $res;
	}
	public function delete($sql, $data = array()){
		$req =$this->db->prepare($sql);
		$res=$req->execute($data);
		return $res;
	}

}
