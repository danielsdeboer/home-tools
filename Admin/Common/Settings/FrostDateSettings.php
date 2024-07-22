<?php

namespace Admin\Common\Settings;

use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Spatie\LaravelSettings\Settings;

class FrostDateSettings extends Settings
{
	public CarbonImmutable $spring;

	public CarbonImmutable $autumn;

	public static function group(): string
	{
		return 'frost_dates';
	}

	public function getSpring(): CarbonImmutable
	{
		return $this->getDate($this->spring);
	}

	public function getAutumn(): CarbonImmutable
	{
		return $this->getDate($this->autumn);
	}

	protected function getDate(CarbonImmutable $date): CarbonImmutable
	{
		$currentYearDate = $date->year(Carbon::now()->year);

		if ($currentYearDate->isPast()) {
			$currentYearDate = $currentYearDate->addYear();
		}

		return $currentYearDate;
	}
}
