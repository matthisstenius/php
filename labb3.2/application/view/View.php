<?php

namespace application\view;

require_once("common/view/Page.php");
require_once("SwedishDateTimeView.php");



class View {
	private $loginView;

	private $registerView;

	private $timeView;
	
	public function __construct($loginView, $registerView) {
		$this->loginView = $loginView;
		$this->registerView = $registerView;

		$this->timeView = new SwedishDateTimeView();
	}
	
	public function getLoggedOutPage() {
		$html = $this->getHeader(false);
		$html .= $this->getRegisterButton();
		$loginBox = $this->loginView->getLoginBox(); 

		$html .= "<h2>Ej Inloggad</h2>
				  	$loginBox
				 ";
		$html .= $this->getFooter();

		return new \common\view\Page("Laboration. Inte inloggad", $html);
	}
	
	public function getLoggedInPage($user) {
		$html = $this->getHeader(true);
		$logoutButton = $this->loginView->getLogoutButton(); 
		$userName = $user->getUserName();

		$html .= "
				<h2>$userName är inloggad</h2>
				 	$logoutButton
				 ";
		$html .= $this->getFooter();

		return new \common\view\Page("Laboration. Inloggad", $html);
	}
	
	public function getRegisterPage() {
		$html = $this->getHeader(false);

		$html .= $this->registerView->getRegisterForm();

		$html .= $this->getFooter();

		return new \common\view\page("Laboration, registrera", $html);
	}

	private function getHeader($isLoggedIn) {
		$ret =  "<h1>Laborationskod xx222aa</h1>";
		return $ret;
		
	}

	private function getFooter() {
		$timeString = $this->timeView->getTimeString(time());
		return "<p>$timeString<p>";
	}
	
	private function getRegisterButton() {
		return "<a href='?register'>Registrera konto</a>";
	}
}
