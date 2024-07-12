<?php

namespace App\Enums;

use JsonSerializable;

enum ResourceIcon: string implements JsonSerializable
{
	case Garden = 'garden';
	case Plot = 'plot';
	case Plant = 'plant';
	case Observation = 'observation';
	case Project = 'project';
	case Bookmark = 'bookmark';

	public function jsonSerialize(): string
	{
		return $this->value;
	}
}
