<?php

namespace view;

date_default_timezone_set("Europe/Stockholm");

class DateTimeView {

	private $serverTime;

	public function __construct (\model\DateTime $serverTime) {
		$this->serverTime = $serverTime;
	}

	public function show() {

		$timeString = $this->serverTime->getDay() . ", the " . $this->serverTime->getIntDay() .  $this->serverTime->getPrefix($this->serverTime->getIntDay()) . " of " . $this->serverTime->getMonth() . " " .$this->serverTime->getYear(). ", The time is " . $this->serverTime->getTime();

		return '<p id="dtv">' . $timeString . '</p>';
	}
}
