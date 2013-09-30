<?php
	namespace view;

	class AdminPage {
		/**
		 * @var model\User $user
		 */
		private $user;

		private static $loginSuccsessMessage = "view::AdminPage::loginSuccsessMessage";
		private static $cookieLogin = "view::AdminPage::cookieLogin";

		private static $logoutButton = "logout";

		public function __construct() {
			$this->user = new \model\User();
		}

		public function setMessage() {
			if ($this->user->isLoggedIn()) {
				$_SESSION[self::$loginSuccsessMessage] = true;
			}
		}
		
		public function setCookieLoginMessage() {
			$_SESSION[self::$cookieLogin] = true;
		}

		/**
		 * @return Boolean
		 */
		public function userLoggesOut() {
			return isset($_GET[self::$logoutButton]);
		}

		/**
		 * @return String html
		 */
		public function getAdminHTML() {
			if ($this->user->isLoggedIn()) {
				$html = "<h1>" . $this->user->getUsername() . " är inloggad</h1>";
			}

			if (isset($_SESSION[self::$loginSuccsessMessage]) && !isset($_SESSION[self::$cookieLogin])) {
				if ($_SESSION[self::$loginSuccsessMessage]) {
					$html .= "<p>inloggningen lyckades</p>";
				}

				unset($_SESSION[self::$loginSuccsessMessage]);
			}

			if (isset($_SESSION[self::$cookieLogin])) {
				if ($_SESSION[self::$cookieLogin]) {
					$html .= "<p>inloggningen lyckades dina uppgifter är sparade</p>";
				}

				unset($_SESSION[self::$cookieLogin]);
			}

			$html .= "<a href='?" . self::$logoutButton ."'>Logga ut</a>";
					
			return $html;
		}
	}