<?php

namespace view;

class Date {

	/**
	 * @return String
	 */
	public function getDateHTML() {
		return "<p>" . self::getLocalDayString() . " den " . date("j") . " " 
					 . self::getLocalMonthString() . " år " . date("Y") .". " 
					 . " Klockan är " . date("H") . ":" . date("i") . ":" . date("s") .
				"</p>";
	}

	/**
	 * @return String day in swedish format
	 */
	private static function getLocalDayString() {
		switch (date("N")) {
			case "1":
				$day = "Måndag";
				break;
			case "2":
				$day = "Tisdag";
				break;
			case '3':
				$day = "Onsdag";
				break;
			case '4':
				$day = "Torsdag";
				break;
			case '5':
				$day = "Fredag";
				break;
			case '6':
				$day = "Lördag";
				break;
			case '7':
				$day = "Söndag";
				break;
			default:
				$day = "The day could not be defined";
		}

		return $day;
	}

	/**
	 * @return String month in swedish format
	 */
	private static function getLocalMonthString() {
		switch (date("n")) {
			case '1':
				$month = "Januari";
				break;
			case '2':
				$month = "Februari";
				break;
			case '3':
				$month = "Mars";
				break;
			case '4':
				$month = "April";
				break;
			case '5':
				$month = "Maj";
				break;
			case '6':
				$month = "Juni";
				break;
			case '7':
				$month = "Juli";
				break;
			case '8':
				$month = "Augusti";
				break;
			case '9':
				$month = "September";
				break;
			case '10':
				$month = "Oktober";
				break;
			case '11':
				$month = "November";
				break;
			case '12':
				$month = "December";
				break;
			default:
				$month = "The month could not be defined"; 
		}

		return $month;
	}
}