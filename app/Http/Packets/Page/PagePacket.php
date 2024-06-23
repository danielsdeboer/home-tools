<?php

namespace App\Http\Packets\Page;

use JsonSerializable;

class PagePacket implements JsonSerializable
{
	public function __construct(
		protected readonly string|null $createRoute = null,
		protected readonly string|null $editRoute = null,
		protected readonly BreadcrumbsPacket|null $breadcrumbs = null,
		protected readonly HeaderPacket|null $header = null,
	)
	{
	}

	public function jsonSerialize(): array
	{
		$data = [];

		if ($this->createRoute) {
			$data['create_route'] = $this->createRoute;
		}

		if ($this->editRoute) {
			$data['edit_route'] = $this->editRoute;
		}

		if ($this->breadcrumbs) {
			$data['breadcrumbs'] = $this->breadcrumbs;
		}

		if ($this->header) {
			$data['header'] = $this->header;
		}

		return $data;
	}
}
