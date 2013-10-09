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

		/**
		 * @param model\User $user
		 */
		public function __construct(\model\User $user) {
			$this->user = $user;
		}

		public function setMessage() {
			if ($this->user->isLoggedIn()) {
				$_SESSION[self::$loginSuccsessMessage] = true;
			}
		}
		
		public function setCookieLoginMessage() {
			if ($this->user->isLoggedIn()) {
				$_SESSION[self::$cookieLogin] = "inloggningen lyckades via cookies";
			}

			else {
				$_SESSION[self::$cookieLogin] = "inloggningen lyckades och vi kommer ihåg dig till nästa gång";
			}
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
					$html .= "<p>";
					$html .= $_SESSION[self::$cookieLogin];
					$html .= "</p>";
				}

				unset($_SESSION[self::$cookieLogin]);
				unset($_SESSION[self::$loginSuccsessMessage]);
			}

			$html .= "<a href='?" . self::$logoutButton ."'>Logga ut</a>";
					
			return $html;
		}
	}