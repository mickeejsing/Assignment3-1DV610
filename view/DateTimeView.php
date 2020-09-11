<?php

class DateTimeView {

	private $serverTime;

	public function __construct (\model\Time $serverTime) {
		$this->serverTime = $serverTime;
	}

	public function show() {

		$timeString = $this->serverTime->getDay() . ", the " . $this->serverTime->getIntDay() . "th of " . $this->serverTime->getMonth() . " " .$this->serverTime->getYear(). ", The time is " . $this->serverTime->getTime();

		return '<p>' . $timeString . '</p>';
	}
}