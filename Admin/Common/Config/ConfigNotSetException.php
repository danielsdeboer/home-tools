<?php

namespace Admin\Common\Config;

use RuntimeException;
use Throwable;

class ConfigNotSetException extends RuntimeException
{
	public static function forKey(
		string $key,
		int $code = 0,
		Throwable|null $previous = null,
	): self {
		return new self(
			message: sprintf('Config not set for key: %s', $key),
			code: $code,
			previous: $previous,
		);
	}
}
