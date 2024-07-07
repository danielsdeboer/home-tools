<?php

namespace App\Http\Packets\Page;

use JsonSerializable;

class HtmlTitlePacket implements JsonSerializable
{
	protected array $parts;

	public function __construct(string ...$parts)
	{
		$this->parts = $parts;
	}

	public function push(string $part): self
	{
		$this->parts[] = $part;

		return $this;
	}

	public function jsonSerialize(): string
	{
		$parts = array_reverse($this->parts);

		return implode(' / ', $parts);
	}
}
