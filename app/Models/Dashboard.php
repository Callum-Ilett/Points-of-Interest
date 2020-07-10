<?php

namespace App\Models;

class Dashboard extends Model{
	private $connection;

	public function __construct() {
		$this->connection = $this->connect();
	}

	public function getCountListings(){
		$sql = "SELECT * FROM pointsofinterest WHERE username = ?";	
    	$stmt = $this->connection->prepare($sql);
		$stmt->execute([$_SESSION['username']]);
		return $stmt->rowCount();
	}

	public function getCountAdminReviews(){
		$sql = "SELECT * FROM poi_reviews WHERE approved = 'pending' ";	
    	$stmt = $this->connection->prepare($sql);
		$stmt->execute();
		return $stmt->rowCount();
	}

	public function getCountUserReviews(){
		$sql = "SELECT * FROM poi_reviews WHERE username = ? and approved = 'pending' ";	
    	$stmt = $this->connection->prepare($sql);
		$stmt->execute([$_SESSION['username']]);
		return $stmt->rowCount();
	}
}