<?php
	namespace model;

	class User {
		private $username = "Matthis";
		private $password =  "Password";	

		public function getUsername() {
			return $this->username;
		}

		public function getPassword() {
			return $this->password;
		}


	}