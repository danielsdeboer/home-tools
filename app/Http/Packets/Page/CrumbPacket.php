<?php

namespace App\Http\Packets\Page;

use JsonSerializable;

/**
 * Represents a breadcrumb in the application. It's called "Crumb" in order to
 * easily distinguish it from the Breadcrumbs (plural) class.
 */
class CrumbPacket implements JsonSerializable
{
	public function __construct(
		private readonly string $text,
		private readonly string $url,
		private readonly bool $disabled = false
	)
	{
	}

	public function jsonSerialize(): array
	{
		return [
			'title' => $this->text,
			'href' => $this->url,
			'disabled' => $this->disabled,
		];
	}
}
