<?php

namespace App\Http\Packets\Page;

use App\Enums\ResourceIcon;
use JsonSerializable;

class HeaderPacket implements JsonSerializable
{
	public function __construct(
		private readonly string $text,
		private readonly ResourceIcon|null $icon = null,
	)
	{
	}

	public function jsonSerialize(): array
	{
		$data = [
			'text' => $this->text,
		];

		if ($this->icon) {
			$data['icon'] = $this->icon;
		}

		return $data;
	}
}
