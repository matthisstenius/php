<?php

namespace view;

class SessionProtect {
	private static $sessionTest = "view::SessionProtect::sessionTest";
	private static $userAgent = "view::SessionProtect::userAgent";
	private static $ip = "view::SessionProtect::ip";

	/**
	 * @throws Exception if session thef
	 */
	public function checkSessionTheft() {
		if (isset($_SESSION[self::$sessionTest])) {
			if ($_SESSION[self::$sessionTest][self::$userAgent] != $_SERVER['HTTP_USER_AGENT']
				|| $_SESSION[self::$sessionTest][self::$ip] != $_SERVER['REMOTE_ADDR']) {
				throw new \Exception("Session theft");
			}	
		}

		else {
			$_SESSION[self::$sessionTest] = array();
			$_SESSION[self::$sessionTest][self::$userAgent] = $_SERVER['HTTP_USER_AGENT'];
			$_SESSION[self::$sessionTest][self::$ip] = $_SERVER['REMOTE_ADDR'];	
		}
	}
}