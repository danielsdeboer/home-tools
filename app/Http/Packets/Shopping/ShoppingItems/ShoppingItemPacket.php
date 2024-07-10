<?php

namespace App\Http\Packets\Shopping\ShoppingItems;

use App\Http\Packets\ModelPacket;
use App\Models\ShoppingItem;

/** @extends ModelPacket<ShoppingItem> */
class ShoppingItemPacket extends ModelPacket
{
	public function pluckedData(): array
	{
		return ['uuid', 'name', 'location'];
	}
}
