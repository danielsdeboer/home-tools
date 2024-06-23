<?php

namespace App\Http\Packets\Links;

use App\Http\Packets\ModelPacket;
use App\Models\Link;

/** @extends ModelPacket<Link> */
class LinkPacket extends ModelPacket
{
	public function pluckedData(): array
	{
		return ['uuid', 'link', 'description'];
	}
}
