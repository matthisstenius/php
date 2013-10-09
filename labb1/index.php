<?php

require_once("src/controller/Application.php");
require_once("src/view/HTMLPage.php");
require_once("src/view/Date.php");

session_start();

$application = new \controller\Application();
$html = $application->startApplication();

$dateView = new \view\Date();

$basehtml = new \view\HTMLPage();
echo $basehtml->getHTML('Laboration 1', $html . $dateView->getDateHTML());

