<?php

namespace App\Http\Packets\Bookmarks;

use App\Http\Packets\ModelPacket;
use App\Models\Bookmark;

/** @extends ModelPacket<Bookmark> */
class BookmarkPacket extends ModelPacket
{
	public function pluckedData(): array
	{
		return ['uuid', 'name', 'url'];
	}
}
