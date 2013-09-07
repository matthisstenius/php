<?php
  require_once('src/view/HTMLPage.php');

  $HTMLPage = new \view\HTMLPage();

  echo $HTMLPage->getHTML('Laboration 1', 'Body ska skrivas här');
