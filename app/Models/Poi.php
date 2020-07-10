<?php

namespace App\Models;

class Poi extends Model {
	private $connection;

	public function __construct() {
		$this->connection = $this->connect();
    }
    
    public function addPoi($data) {
        $sql = "INSERT INTO pointsofinterest (name, type, country, region, description, username) VALUES (:name, :type, :country, :region, :description, :username)";	
    	$stmt = $this->connection->prepare($sql);
		$stmt->execute([
            ':name'=>$data['name'],
            ':type'=>$data['category'],
            ':country'=>$data['country'],
            ':region'=>$data['region'],
            ':description'=>$data['description'],
            ':username'=>$_SESSION['username']
        ]);
    }

    public function getAll(){
		$sql = "SELECT * FROM pointsofinterest ORDER BY ID ASC ";
   		$stmt = $this->connection->prepare($sql);
		$stmt->execute();

		return $stmt->fetchAll();
	}

	public function getByUsername(){
		$sql = "SELECT * FROM pointsofinterest WHERE username = ?";	
    	$stmt = $this->connection->prepare($sql);
		$stmt->execute([$_SESSION['username']]);
		return $stmt->fetchAll();
	}

	public function getbyName($name){
		$sql = "SELECT * FROM pointsofinterest WHERE name = ?";	
    	$stmt = $this->connection->prepare($sql);
		$stmt->execute([$name]);
		return $stmt->fetch();
	}

	public function getByRegion($region){
		$sql = "SELECT * FROM pointsofinterest WHERE region = ? AND image IS NOT NULL ORDER BY name ASC ";
   		$stmt = $this->connection->prepare($sql);
		$stmt->execute([$region]);

		return $stmt->fetchAll();
    }
    
    public function getByCategory($category){
		$sql = "SELECT * FROM pointsofinterest WHERE type = ? ORDER BY name ASC ";
   		$stmt = $this->connection->prepare($sql);
		$stmt->execute([$category]);

		return $stmt->fetchAll();
	}

	public function addRecommendation($id){
		$sql = "UPDATE pointsofinterest SET recommended = recommended + 1 WHERE ID = ?";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([$id]);
	}

}