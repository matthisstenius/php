<?php
	// @todo remove this file
	require_once('src/view/LoginPage.php');
	
	$loginPage = new \view\LoginPage();

	echo $loginPage->getLoginHTML();