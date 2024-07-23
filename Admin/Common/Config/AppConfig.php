<?php

namespace Admin\Common\Config;

use Carbon\Carbon;

class AppConfig extends ConfigAbstract
{
	public function base(): string
	{
		return 'app';
	}

	public function getSpringFrostDate(): Carbon
	{
		return Carbon::parse($this->safeGet('frost_dates', 'spring'))
			->year(Carbon::now()->year);
	}

	public function getAutumnFrostDate(): Carbon
	{
		return Carbon::parse($this->safeGet('frost_dates', 'autumn'))
			->year(Carbon::now()->year);
	}
}
