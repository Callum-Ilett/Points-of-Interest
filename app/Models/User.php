<?php

namespace App\Models;

class User extends Model{
	private $connection;

	public function __construct() {
		$this->connection = $this->connect();
	}

	public function create($username, $password){
		$sql = "INSERT INTO poi_users(username, password, isAdmin) VALUES(?, ?, 0)";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([$username, $password]);
	}

	public function getUserByUsername($username){
		$sql = "SELECT * FROM poi_users WHERE username = ?";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([$username]);

		$data = $stmt->fetch();
		return $data;
	}

	public function checkAdmin($username, $condition) {
		$sql = "SELECT * FROM poi_users WHERE username = ? and isAdmin = ?";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([$username, $condition]);

		$data = $stmt->fetch();
		return $data;
	}
	
}