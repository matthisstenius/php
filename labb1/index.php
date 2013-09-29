<?php

require_once("src/controller/Application.php");
require_once("src/view/HTMLPage.php");

session_start();

$application = new \controller\Application();
$html = $application->startApplication();

$basehtml = new \view\HTMLPage();
echo $basehtml->getHTML('Laboration 1', $html);

