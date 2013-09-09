<?php
  require_once('src/view/HTMLPage.php');
  require_once('src/controller/Login.php');
  require_once("src/model/Login.php");

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
	}
  }

  else {
  	echo $HTMLPage->getHTML('Laboration 1', 'Ange användarnamn samt lösenord för att logga in');
  }




	