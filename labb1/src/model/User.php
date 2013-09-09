<?php
	namespace model;

	class User {
		private static $username = "admin";
		private static $password =  "password";	

		public function getUsername() {
			return self::$username;
		}

		public function getPassword() {
			return self::$password;
		}


	}