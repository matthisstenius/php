<?php
	namespace model;

	class User {
		private static $username = "admin";
		private static $password =  "password";	

		private static $setLoginStatus = "model::User::setLoginStatus";

		/**
		 * @var String
		 */
		public $token = "3468c4618ce69651192682c1324c2562";

		/**
		 * @return String
		 */
		public function getUsername() {
			return self::$username; 
		}

		/**
		 * @return String
		 */
		public function getPassword() {
			return self::$password;
		}

		/**
		 * @return boolean
		 */
		public function isLoggedIn() {
			return isset($_SESSION[self::$setLoginStatus]);
		}

		public function setLogin() {
			$_SESSION[self::$setLoginStatus] = true;	
		}

		public function unsetLogin() {
			unset($_SESSION[self::$setLoginStatus]);
		}
	}