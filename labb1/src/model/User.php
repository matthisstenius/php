<?php
	namespace model;

	class User {
		private static $username = "admin";
		private static $password =  "password";	

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


	}