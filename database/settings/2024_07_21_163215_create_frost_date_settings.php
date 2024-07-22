<?php

use Admin\Common\Config\AppConfig;
use Spatie\LaravelSettings\Migrations\SettingsMigration;

return new class extends SettingsMigration {
	public function up(): void
	{
		$config = resolve(AppConfig::class);

		$this->migrator->add(
			'frost_dates.spring',
			$config->getSpringFrostDate(),
		);

		$this->migrator->add(
			'frost_dates.autumn',
			$config->getAutumnFrostDate(),
		);
	}
};
