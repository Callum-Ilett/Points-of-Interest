<?php

namespace App\Auth;
class Auth {

	public function user(){
        if(isset($_SESSION['username'])){
            return $_SESSION['username'];
        }
	}

	public function isAdmin(){
        if(isset($_SESSION['username'])){
			$user = new \App\Models\User();
			$row = $user->checkAdmin($_SESSION['username'], 1);
            return $row == 1 ? true : false;
        }
	}

	public static function check(){
		return isset($_SESSION['username']);
	}

	public function attempt($username, $password) {
		$user = new \App\Models\User();
		$userData = $user->getUserByUsername($username);

		if(!$user) {
			return false;
		}

		if($password == $userData->password) {
			$_SESSION['username'] = $userData->username;
			return  true;
		}

		return false;
	}

}