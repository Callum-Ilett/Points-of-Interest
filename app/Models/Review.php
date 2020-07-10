<?php

namespace App\Models;

class Review extends Model{

	private $connection;

	public function __construct() {
		$this->connection = $this->connect();
	}

	public function create($params){
		$sql = "INSERT INTO poi_reviews(poi_id, name, review, approved, username) VALUES(?, ?, ?, ?, ?)";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute($params);
    }
    
    public function aprroveReview($id) {
        $sql = "UPDATE poi_reviews SET approved = 'approved' WHERE id = ?";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([$id]);
	}
	
	public function cancelReview($id) {
        $sql = "UPDATE poi_reviews SET approved = 'canceled' WHERE id = ?";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([$id]);
    }

    
    public function getAdminReviews() {
        $sql = "SELECT * FROM poi_reviews WHERE approved = 'pending'";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute();

		return $stmt->fetchAll();
    }

	public function getReviewsByID($id){
		$sql = "SELECT * FROM poi_reviews WHERE poi_id = ? AND approved = 'approved'";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([$id]);

		return $stmt->fetchAll();
	}

	public function getAllReviews($username){
		$sql = "SELECT * FROM poi_reviews WHERE username = ?";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([$username]);

		return $stmt->fetchAll();
    }

    public function getApprovedReviews($username){
        $sql = "SELECT * FROM poi_reviews WHERE username = ? AND approved = 'approved' ";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([$username]);

		return $stmt->fetchAll();
    }
    
    public function getPendingReviews($username){
        $sql = "SELECT * FROM poi_reviews WHERE username = ? AND approved = 'pending' ";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([$username]);

		return $stmt->fetchAll();
    }

    public function getCanceledReviews($username){
        $sql = "SELECT * FROM poi_reviews WHERE username = ? AND approved = 'canceled' ";
		$stmt = $this->connection->prepare($sql);
		$stmt->execute([$username]);

		return $stmt->fetchAll();
    }

}