<?php

namespace App\Http\Packets\Page;

use JsonSerializable;

class BreadcrumbsPacket implements JsonSerializable
{
	/** @var list<CrumbPacket> */
	private array $breadcrumbs;

	public function __construct(CrumbPacket ...$breadcrumbs)
	{
		$this->breadcrumbs = $breadcrumbs;
	}

	public function push(CrumbPacket $breadcrumb): self
	{
		$this->breadcrumbs[] = $breadcrumb;

		return $this;
	}

	public function pushDisabled(string $text): self
	{
		$this->breadcrumbs[] = new CrumbPacket($text, '', true);

		return $this;
	}

	public function jsonSerialize(): array
	{
		return $this->breadcrumbs;
	}
}
