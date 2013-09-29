<?php
	namespace model;

	class User {
		/**
		 * @todo refactor this validation to view and remove this class
		 */
		private static $username = "admin";
		private static $password =  "password";	

		private static $setLoginStatus = "model::User::setLoginStatus";

		/**
		 * @return String
		 */
		public function getUsername() {
			return htmlspecialchars(self::$username); 
		}

		/**
		 * @return String
		 */
		public function getPassword() {
			return htmlspecialchars(self::$password);
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