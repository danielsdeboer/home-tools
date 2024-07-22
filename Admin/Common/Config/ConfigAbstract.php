<?php

namespace Admin\Common\Config;

use Illuminate\Contracts\Config\Repository;

abstract class ConfigAbstract
{
	public function __construct(protected readonly Repository $config)
	{
	}

	abstract public function base(): string;

	/** @param list<string> $path */
	public function safeGet(string ...$path): mixed
	{
		array_unshift($path, $this->base());

		$key = implode('.', $path);

		$value = $this->config->get($key);

		if ($value === null) {
			throw ConfigNotSetException::forKey($key);
		}

		return $value;
	}
}
