<?php

namespace view;

date_default_timezone_set("Europe/Stockholm");

class DateTimeView {

	private $serverTimeModel;

	public function __construct (\model\DateTime $serverTime) {
		$this->serverTimeModel = $serverTime;
	}

	public function show() : string {

		$timeString = date("l") . ", the " . date("j") .  $this->printPrefix() . " of " . date("F") . " " .date("Y"). ", The time is " . date("h:i:s");

		return '<p id="dtv">' . $timeString . '</p>';
	}

	public function printPrefix () {

		$number = $this->serverTimeModel->calculatePrefix(date("j"));

		if ($number == 1) {
			return "st";
		} else if ($number == 2) {
			return "nd";
		} else if ($number == 3) {
			return "rd";
		} else if ($number > 3) {
			return "th";
		}
	}
}
