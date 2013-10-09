<?php
namespace view;

class HTMLPage {
	/**
	 * @param String $title
	 * @param String $body html string
	 * @return String html
	 */
	public function getHTML($title, $body) {
		$html = "<!DOCTYPE html>
		<html lang='sv'>
		<head>
			<title>$title</title>
			<meta charset='utf-8'>
		</head>
		<body>";

		$html .= $body;

		$html .= "
		</body>
		</html>";

		return $html;
	}
}


