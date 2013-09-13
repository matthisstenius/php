<?php
  require_once('src/view/HTMLPage.php');
  require_once('src/controller/Login.php');
  require_once("src/model/Login.php");
  require_once("src/view/AdminPage.php");

  session_start();

  $HTMLPage = new \view\HTMLPage();

  if (isset($_POST['login'])) {
  	try {
  		$loginAtempt = new \model\Login($HTMLPage);	
  	}

  	catch (Exception $e) {
  		echo $HTMLPage->getHtml($e->getMessage(), $e->getMessage());
  		exit;
  	}
  	
  	$login = new \controller\Login($loginAtempt);
	
	try {
		$login->isLoggedIn();	
	}
	
	catch (Exception $e) {
		echo $HTMLPage->getHTML($e->getMessage(), $e->getMessage());
		exit;
	}
  }

  elseif (isset($_GET['logout']) && isset($_SESSION['user'])) {
  	unset($_SESSION['user']);
  	$_SESSION['logoutMessage'] = "Du har nu loggat ut";
  	echo $HTMLPage->getHTML('Laboration 1', $_SESSION['logoutMessage']);
  	unset($_SESSION['logoutMessage']);
  }

  elseif (isset($_SESSION['user'])) {
  	if (isset($_SESSION['welcomeMessage'])) {
  		unset($_SESSION['welcomeMessage']);
  	}

  	$AdminPage = new \view\AdminPage($_SESSION['user']);

  	echo $AdminPage->getAdminHTML();
  }

  else {
  	echo $HTMLPage->getHTML('Laboration 1', 'Ange användarnamn samt lösenord för att logga in');
  }
  




	